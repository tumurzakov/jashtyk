<?php
class ClientsController extends AppController {
	var $name = 'Clients';
    var $components = array('Auth', 'Session', 'Access');
    var $uses = array('Client', 'Group', 'RoomSession');

    function beforeFilter() {
        parent::beforeFilter(); 
    }

	function index() {
        $this->set('pattern', $pattern = isset($this->data['pattern']) ? $this->data['pattern'] : $this->Session->read('clients_pattern'));
        $this->Session->write('clients_pattern', $pattern);

        if (!empty($pattern)) $this->paginate = array(
            'joins'=>array('LEFT JOIN ips AS Ip ON (Client.id = Ip.client_id)'),
            'group'=>array("Client.id", "Client.name", 
                "Client.description", "Client.client_type_id", "ClientType.name"),
            'fields'=>array("Client.id", "Client.name", 
                "Client.description", "Client.client_type_id", "ClientType.name", 
                "ClientType.description"),
            'order'=>'Client.name ASC',
            'pattern'=>$pattern,
            'conditions'=>array(
                'OR'=>array(
                    'Client.name LIKE'=>"%$pattern%",
                    'INET_NTOA(Ip.ip) LIKE'=>"%$pattern%"
                )));

		$this->set('clients', $this->paginate());
        $this->set('status', $this->Access->status());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid client id', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('client', $this->Client->read(null, $id));
        $this->set('status', $this->Access->status());
	}

	function add() {
		if (!empty($this->data)) {
            $group = $this->Group->findByName(__('Clients', true));

			$this->Client->create();
			if ($this->Client->save($this->data)) {
				$this->Session->setFlash(__('The client has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.', true));
			}
		}
		$clientTypes = $this->Client->ClientType->find('list');
		$this->set(compact('clientTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid client id', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            $client = $this->Client->read(null, $this->data['Client']['id']);

			if ($this->Client->save($this->data)) {
				$this->Session->setFlash(__('The client has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Client->read(null, $id);
		}
		$clientTypes = $this->Client->ClientType->find('list');
		$this->set(compact('clientTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for client', true));
			$this->redirect(array('action'=>'index'));
		}
        $client = $this->Client->findById($id);
		if ($this->Client->delete($id)) {
			$this->Session->setFlash(__('Client deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Client was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function access($id, $action) {
        $client = $this->Client->read(null, $id);
        if ($client) {
            foreach($client['Ip'] as $ip) {
                if ($action == 'allow') {
                    $this->Access->allow($ip['ip']);
		            $this->Session->setFlash(__('Client turned on', true));
                } else {
                    $this->Access->deny($ip['ip']);
		            $this->Session->setFlash(__('Client turned off', true));
                }
            }
        }

		$this->redirect($this->Session->read('last_location'));
    }
}
?>
