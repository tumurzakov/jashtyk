<?php
class RoomSessionsController extends AppController {
    var $components = array('Date');
    var $uses = array('Config', 'Client', 'RoomSession', 'Tariff', 'ClientType', 'RoomSessionStatus', 'Payment');

    function index() {
        $begin = !isset($this->data['RoomSession']['month']) ? strftime('%Y-%m-01') : 
            sprintf('%s-%s-01', $this->data['RoomSession']['month']['year'], 
            $this->data['RoomSession']['month']['month']);

        $end = strftime("%F", strtotime('+1 month', strtotime($begin)));
        $filter = !empty($this->data['RoomSession']['filter']) ? "{$this->data['RoomSession']['filter']}%" : "%";

        $report = array();
        $rooms = $this->Client->find('all', array(
            'conditions'=>array(
                'ClientType.name'=>array('Room', 'Appartment'), 
            ),
            'order'=>'Client.name'));

        foreach($rooms as $room) {
            $report[$room['Client']['id']] = array(
                'name'=>$room['Client']['name'],
                'type'=>$room['ClientType']['name'],
                'type_name'=>$room['ClientType']['description'],
                'status'=>$this->Client->getStatus($room['Client']['id']),
                'sessions'=>array()
                );
        }

        $sessions = $this->RoomSession->find('all', array(
            'recursive'=>-1,
            'order'=>'room_session_status_id, start ASC',
            'fields'=>array(
                'RoomSession.*', 'Tariff.*', 'RoomSessionStatus.*'
            ),
            'joins'=>array(
                array('table'=>$this->RoomSessionStatus->table, 'alias'=>'RoomSessionStatus', 'type'=>'LEFT',
                    'conditions'=>'RoomSession.room_session_status_id = RoomSessionStatus.id'),
                array('table'=>$this->Tariff->table, 'alias'=>'Tariff', 'type'=>'LEFT', 
                    'conditions'=>'RoomSession.tariff_id = Tariff.id'),
                array('table'=>$this->Client->table, 'alias'=>'Client', 'type'=>'LEFT', 
                    'conditions'=>'RoomSession.client_id = Client.id'),
                array('table'=>$this->ClientType->table, 'alias'=>'ClientType', 'type'=>'LEFT',
                    'conditions'=>'Client.client_type_id = ClientType.id')
            ),
            'conditions'=>array(
                'RoomSession.name LIKE'=>$filter,
                'or'=>array(
                    'RoomSessionStatus.name'=>'Started',
                    'RoomSession.start BETWEEN ? AND ?' => array($begin, $end)
                )
            )));

        foreach($sessions as $session) {
            $session['usage'] = $this->Tariff->getUsage($session);
            $report[$session['RoomSession']['client_id']]['sessions'][] = $session;
        }

        if ($filter != "%") {
            $filtered = array();
            foreach($report as $key => $value) {
                if (!empty($value['sessions'])) $filtered[$key] = $value;
                if (preg_match('/'.str_replace('%', '.*', $filter).'/', $value['name'])) $filtered[$key] = $value;
            }
            $report = $filtered;
        }

        $this->set(compact('report'));
    }

    function add() {
		if (!empty($this->data)) {
			$this->RoomSession->create();

            $status = $this->RoomSessionStatus->findByName('Not started');
            $this->data['RoomSession']['room_session_status_id'] = $status['RoomSessionStatus']['id'];
            $this->data['RoomSession']['limit'] = 0;
            $this->data['RoomSession']['balance'] = 0;
            $this->data['RoomSession']['global_in'] = 0;
            $this->data['RoomSession']['global_out'] = 0;
            $this->data['RoomSession']['peering_in'] = 0;
            $this->data['RoomSession']['peering_out'] = 0;

            $tariff = null;
            if (isset($this->data['RoomSession']['tariff_id']) && !empty($this->data['RoomSession']['tariff_id'])) {
                $tariff = $this->Tariff->findById($this->data['RoomSession']['tariff_id']);
                $this->data['RoomSession']['limit'] = $tariff['Tariff']['default_limit'];
            }

			if ($this->RoomSession->save($this->data)) {

                if ($tariff) {
                    $this->Payment->add(array('Payment'=>array(
                        'room_session_id'=>$this->RoomSession->id,
                        'amount'=>$tariff['Tariff']['starting_balance'],
                        'description'=>__('Starting balance', true),
                        )), 'payment');
                }

				$this->Session->setFlash(__('The room session has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room session could not be saved. Please, try again.', true));
			}
		}

        $this->setClientAndTariffLists();
    }


	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid room session', true));
			$this->redirect(array('action' => 'index'));
		}
        $session = $this->RoomSession->read(null, $id);
        $session['usage'] = $this->Tariff->getUsage($session);

		$this->set('roomSession', $session);

        $payments = $this->Payment->find('all', array(
            'conditions'=>array('Payment.room_session_id'=>$id),
            'order'=>array('Payment.created ASC')));
        $this->set('payments', $payments);

	}

    function changeTraffic($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid room session', true));
			$this->redirect(array('action' => 'index'));
		}

        $roomSession = $this->RoomSession->findById($id) ;
		if (!empty($this->data)) {
            unset($roomSession['RoomSession']['modified']);

            $changed = false;
            foreach(array('global_in', 'global_out', 'peering_in', 'peering_out') as $dir) {
                if ($this->data['RoomSession'][$dir] == "") continue;

                $this->data['RoomSession'][$dir] *= MEGABYTE;
                if ($this->data['RoomSession'][$dir] >= 0) {
                    $roomSession['RoomSession'][$dir] = $this->data['RoomSession'][$dir];
                } else {
                    $roomSession['RoomSession'][$dir] += $this->data['RoomSession'][$dir];
                }
                $changed = true;
            }

			if ($changed && $this->RoomSession->save($roomSession)) {
                
                $this->Payment->event($roomSession['RoomSession']['id'], 
                    __(sprintf('Traffic changed (%s)[global_in=%.2f, global_out=%.2f, peering_in=%.2f, peering_out=%.2f]',
                        $this->data['RoomSession']['description'],
                        $roomSession['RoomSession']['global_in']/MEGABYTE,
                        $roomSession['RoomSession']['global_out']/MEGABYTE,
                        $roomSession['RoomSession']['peering_in']/MEGABYTE,
                        $roomSession['RoomSession']['peering_out']/MEGABYTE
                    ), true));

				$this->Session->setFlash(__('Traffic successfully changed', true));
                $this->redirect($this->Session->read('last_location'));

			} else {
				$this->Session->setFlash(__('The room session could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RoomSession->read(null, $id);
		}
        $this->set(compact('roomSession'));
    }

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid room session', true));
			$this->redirect(array('action' => 'index'));
		}

        $roomSession = $this->RoomSession->findById($id) ;
		if (!empty($this->data)) {
            unset($roomSession['RoomSession']['modified']);
            $fields = array('name', 'description', 'start', 'end', 'limit');

            if (in_array($roomSession['RoomSessionStatus']['name'], array('Not started', 'Completed'))) {
                $fields[] = 'client_id';
                $fields[] = 'tariff_id';
            }

            foreach($fields as $field) {
                if (isset($this->data['RoomSession'][$field]))
                    $roomSession['RoomSession'][$field] = $this->data['RoomSession'][$field];
            }

			if ($this->RoomSession->save($roomSession)) {
				$this->Session->setFlash(__('The room session has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room session could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RoomSession->read(null, $id);
		}
        $this->setClientAndTariffLists();
        $this->set(compact('roomSession'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for room session', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RoomSession->delete($id)) {
			$this->Session->setFlash(__('Room session deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Room session was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function startNow($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for room session', true));
			$this->redirect(array('action'=>'index'));
		}

        $roomSession = $this->RoomSession->findById($id) ;

        $this->checkClientIsSet($roomSession);
        $this->checkTariffIsSet($roomSession);
        $this->checkIfExistStartedSession($roomSession);
        $this->checkBalance($roomSession);

        if ($this->RoomSession->start($roomSession)) {
            $this->Session->setFlash(__('Room session started', true));
            $this->redirect($this->Session->read('last_location'));
        }

		$this->Session->setFlash(__('Room session was not started', true));
		$this->redirect($this->Session->read('last_location'));
    }

    function endNow($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for room session', true));
			$this->redirect(array('action'=>'index'));
		}

        $roomSession = $this->RoomSession->findById($id) ;

        $this->checkClientIsSet($roomSession);
        $this->checkTariffIsSet($roomSession);

		if ($this->RoomSession->stop($roomSession)) {
			$this->Session->setFlash(__('Room session completed', true));
			$this->redirect($this->Session->read('last_location'));
		}
		$this->Session->setFlash(__('Room session was not completed', true));
		$this->redirect($this->Session->read('last_location'));
    }

    function invoice($id) {
        $this->layout = 'invoice';
        Configure::write('Config.language', 'eng');

        $roomSession = $this->RoomSession->findById($id);
        $payments = $this->Payment->find('all', array(
            'conditions'=>array('Payment.room_session_id'=>$id),
            'order'=>array('Payment.created ASC')));
        $this->set(compact('roomSession', 'payments'));
    }

    private function setClientAndTariffLists() {
        $tariffs = $this->Tariff->find('list', array('order'=>'name'));
        $tariffs[0] = '';
        ksort($tariffs);

        $clients = $this->Client->find('list', array('fields'=>array('Client.id', 'Client.name'), 'order'=>'name'));
        $clients[0] = '';
        ksort($clients);

        $this->set(compact('tariffs', 'clients')); 
    }

    private function checkClientIsSet($roomSession) {
        if (!$roomSession['RoomSession']['client_id']) {
            $this->Session->setFlash(__("Room must be specified to start the session", true));
            $this->redirect(array('action' => 'index'));
        }
    }

    private function checkTariffIsSet($roomSession) {
        if (!$roomSession['RoomSession']['tariff_id']) {
            $this->Session->setFlash(__("Tariff must be specified to start the session", true));
            $this->redirect(array('action' => 'index'));
        }
    }

    private function checkIfExistStartedSession($roomSession) {
        if ($this->RoomSession->find('first', array('conditions'=>array(
            'RoomSessionStatus.name'=>'Started', 
            'RoomSession.client_id'=>$roomSession['RoomSession']['client_id'])))) {

            $this->Session->setFlash(__("There is already started session, close it first", true));
            $this->redirect(array('action' => 'index'));
        }
    }

    private function checkBalance($roomSession) {
        if ($roomSession['RoomSession']['balance'] < $roomSession['RoomSession']['limit']) {
            $this->Session->setFlash(__("Not enaught balance to start session", true));
            $this->redirect(array('action' => 'index'));
        }
    }
}
?>
