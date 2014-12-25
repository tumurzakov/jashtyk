<?php
App::import("Component", "Date");
App::import("Component", "Network");

class RoomSession extends AppModel {
	var $name = 'RoomSession';
	var $displayField = "name";

	var $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tariff' => array(
			'className' => 'Tariff',
			'foreignKey' => 'tariff_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RoomSessionStatus' => array(
			'className' => 'RoomSessionStatus',
			'foreignKey' => 'room_session_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)

	);

    function __construct( $id = false, $table = NULL, $ds = NULL ) {
        parent::__construct($id, $table, $ds);
        $this->RoomSessionStatus = ClassRegistry::init("RoomSessionStatus");
        $this->Payment = ClassRegistry::init('Payment');
        $this->Client = ClassRegistry::init("Client");
        $this->Tariff = ClassRegistry::init("Tariff");
        $this->Config = ClassRegistry::init("Config");
        $this->Date = new DateComponent(null);
    }

    function start($roomSession) {
        $status = $this->RoomSessionStatus->findByName('Started');
        $roomSession['RoomSession']['start'] = strftime("%Y-%m-%d %H:%M:%S", $this->Date->now());

        if (isset($status)) {
            $roomSession['RoomSession']['room_session_status_id'] = $status['RoomSessionStatus']['id'];
            unset($roomSession['RoomSession']['modified']);
            $this->save($roomSession);
            $this->Client->allow($roomSession['Client']['id']);
        }

        $this->Payment->event($roomSession['RoomSession']['id'], 
            __('Session started', true));

        return true;
    }

    function stop($roomSession) {
        $status = $this->RoomSessionStatus->findByName('Completed');
        $roomSession['RoomSession']['end'] = strftime("%Y-%m-%d %H:%M:%S", $this->Date->now());
        $roomSession['RoomSession']['room_session_status_id'] = $status['RoomSessionStatus']['id'];
        unset($roomSession['RoomSession']['modified']);
		$this->save($roomSession);

        $this->Client->deny($roomSession['Client']['id']);
        $this->charge($roomSession);
        $this->Payment->event($roomSession['RoomSession']['id'], __('Session ended', true));

        return true;
    }

    function charge($roomSession) {
        $usage = $this->Tariff->getUsage($roomSession);
        $currency = $this->Config->get('currency');
        $this->Payment->add(array('Payment'=>array(
            'room_session_id'=>$roomSession['RoomSession']['id'],
            'amount'=>-$usage['usage'],
            'description'=>sprintf(
                __('Charge: global: %.2f Mb * %.2f %s = %.2f %s, peering: %.2f Mb * %.2f %s = %.2f %s', true),
                $usage['global'], $usage['globalPrice'], $currency, $usage['globalUsage'], $currency,
                $usage['peering'], $usage['peeringPrice'], $currency, $usage['peeringUsage'], $currency)
        )), 'charge');

        $roomSession = $this->read(null, $roomSession['RoomSession']['id']);
        $roomSession['RoomSession']['global_in'] = 0;
        $roomSession['RoomSession']['global_out'] = 0;
        $roomSession['RoomSession']['peering_in'] = 0;
        $roomSession['RoomSession']['peering_out'] = 0;
		$this->save($roomSession);
    }

    function update($ip, $statistic) {
        $ipDAO = ClassRegistry::init('Ip');
        $ipDAO->recursive = 0;

        $ip_str = long2ip($ip);
        $ip_uint = NetworkComponent::int2uint($ip);
        $ipObject = $ipDAO->findByIp($ip_uint);

        if (!$ipObject) {
            $this->log("Ip address not found $ip_str, skipping...");
            return;
        }

        $session = $this->find('first', array('conditions'=>array(
            'RoomSession.client_id'=>$ipObject['Ip']['client_id'],
            'RoomSessionStatus.name'=>'Started')));

        if ($session) {
            $session['RoomSession']['global_in'] += $statistic['global_in'];
            $session['RoomSession']['global_out'] += $statistic['global_out'];
            $session['RoomSession']['peering_in'] += $statistic['peering_in'];
            $session['RoomSession']['peering_out'] += $statistic['peering_out'];

            $this->save($session);
        }
    }

    function setStatus($session, $status) {
        $status = $this->RoomSessionStatus->findByName($status);
        $this->read(null, $session['RoomSession']['id']);
        $this->set('room_session_status_id', $status['RoomSessionStatus']['id']);
        $this->save();
    }

    function stopSessions($clientId) {
        $sessions = $this->find('all', array('conditions'=>array(
            'client_id'=>$clientId, 'RoomSessionStatus.name'=>'Started'
            )));
        foreach($sessions as $session) {
            $this->setStatus($session, 'Completed');
        }
    }
}
?>
