<?php
class PaymentsController extends AppController {
	var $name = 'Payments';
    var $uses = array('Payment', 'RoomSession');

	function index($sessionId = null) {
        $begin = !isset($this->data['Payment']['date']) ? strftime('%Y-%m-%d') : 
            sprintf('%s-%s-%d', $this->data['Payment']['date']['year'], 
            $this->data['Payment']['date']['month'], $this->data['Payment']['date']['day']);

        $end = strftime("%F", strtotime('+1 day', strtotime($begin)));

        $filter = !empty($this->data['Payment']['filter']) ? "{$this->data['Payment']['filter']}%" : "%";


		$this->Payment->recursive = 0;
        $conditions = array('Payment.created BETWEEN ? AND ?'=>array($begin, $end), 'RoomSession.name LIKE'=>$filter);
        if ($sessionId) 
            $conditions['room_session_id']=$sessionId;
        $this->paginate = array(
            'conditions'=>$conditions,
            'order'=>'Payment.created DESC'
        );

		$this->set('payments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function add($sessionId = null) {
		if (!empty($this->data)) { 
            if (!isset($this->data['Payment']['room_session_id']) ||
                $this->data['Payment']['room_session_id'] == 0) {
				$this->Session->setFlash(__('There are no active sessions.', true));
            } else if ($this->data['Payment']['amount'] == 0) {
				$this->Session->setFlash(__('You have not specified an amount', true));
			}

            $sessionId = $this->data['Payment']['room_session_id'];

            try {
                if ($this->Payment->add($this->data, 'payment')) {
			        $this->Session->setFlash(__('The payment has been saved', true));
                } else {
				    $this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
                }
            } catch(Exception $ex) {
                $this->setFlash($ex->getMessage());
            }

			$this->redirect(array('action' => 'index', $sessionId));
		}

        if ($sessionId == null) 
            $this->cakeError('error404', array('message'=>__('Please specify session for payment', true)));

        $roomSession = $this->RoomSession->findById($sessionId);
		$this->set(compact('roomSession'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid payment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Payment->modify($this->data)) {
				$this->Session->setFlash(__('The payment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.', true));
			}

            try {
                $this->Payment->modify($this->data);
            } catch(Exception $ex) {
                $this->setFlash($ex->getMessage());
            }

		}
		if (empty($this->data)) {
			$this->data = $this->Payment->read(null, $id);
		}
		$roomSessions = $this->Payment->RoomSession->find('list');
		$this->set(compact('roomSessions'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for payment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Payment->delete($id)) {
			$this->Session->setFlash(__('Payment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Payment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
