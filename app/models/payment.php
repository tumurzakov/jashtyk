<?php
App::import('Component', 'Session');
class Payment extends AppModel {
    var $belongsTo = array('RoomSession', 'PaymentCategory', 'User');

    function __construct( $id = false, $table = NULL, $ds = NULL ) {
        parent::__construct($id, $table, $ds);
        $this->Session = ClassRegistry::init('RoomSession');
        $this->PaymentCategory = ClassRegistry::init('PaymentCategory');
    }


    function add($payment, $category) {
        $Session = new SessionComponent();
        $user = $Session->read('Auth.User');
        $payment['Payment']['user_id'] = $user['id'];

        $payment['Payment']['payment_category_id'] = 
            $this->PaymentCategory->get($category);

        $session = $this->Session->findById($payment['Payment']['room_session_id']);
        if (!$this->query(sprintf("UPDATE room_sessions SET balance = balance + %.2f WHERE id=%d", 
            $payment['Payment']['amount'], $payment['Payment']['room_session_id']))) {
            throw new Exception("Adding payment failed [Updating balance]");
        }
        return $this->save($payment);
    }

    function event($sessionId, $msg) {
        if (empty($msg)) return;

        $this->create();

        $Session = new SessionComponent();
        $user = $Session->read('Auth.User');

        $this->set(array(
            'user_id'=>$user['id'],
            'payment_category_id'=>$this->PaymentCategory->get('event'),
            'room_session_id'=>$sessionId,
            'description'=>$msg
            ));

        return $this->save();
    }

    function modify($payment) {
        $Session = new SessionComponent();
        $user = $Session->read('Auth.User');
        $payment['Payment']['user_id'] = $user['id'];

        $before = $this->findById($payment['Payment']['id']);
        $difference = $payment['Payment']['amount'] - $before['Payment']['amount'];
        if (!$this->query(sprintf("UPDATE room_sessions SET balance = balance + %.2f WHERE id=%d", 
            $difference, $before['Payment']['room_session_id']))) {
            throw new Exception("Modifying payment failed [Updating balance]");
        }
        unset($payment['Payment']['room_session_id']);

        $this->event($before['Payment']['room_session_id'], sprintf(
            __('Payment modified amount changed from %.2f to %.2f', true), 
                $payment['Payment']['amount'], $before['Payment']['amount']));

        return $this->save($payment);
    }

    function delete($id) {
        $payment = $this->findById($id);
        $session = $this->Session->findById($payment['Payment']['room_session_id']);
        if (!$this->query(sprintf("UPDATE room_sessions SET balance = balance - %.2f WHERE id=%d", 
            $payment['Payment']['amount'], $payment['Payment']['room_session_id']))) {
            throw new Exception("Deleting payment failed [Updating balance]");
        }

        $this->event($payment['Payment']['room_session_id'], sprintf(
            __('Payment deleted amount %.2f', true), $payment['Payment']['amount']));

        parent::delete($id);
    }
}
