<?php
class IpsController extends AppController {

    var $components = array('Access');

	var $name = 'Ips';

	function index() {
		$this->Ip->recursive = 0;
        $this->set('macs', $this->Access->macs());
		$this->set('ips', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ip', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ip', $this->Ip->read(null, $id));
	}

    function add($clientId) {
        $client = $this->Ip->Client->findById($clientId);
        try {
            if ($client && !empty($this->data)) {
                $startIp = $this->data['Ip']['start_ip'];
                $count = $this->data['Ip']['count'];

                if (empty($count)) {
                    throw new Exception(__("You haven't specified an count parameter", true));
                }

                if (!preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3})\.(\d{1,3})/', $startIp, $matches)) {
                    throw new Exception(__("Invalid IP address format", true));
                }

                $network = $matches[1];
                $lastOctet = $matches[2];

                if ($lastOctet == 0) {
                    throw new Exception(__("You must specify first IP address of network", true));
                }

                if ($lastOctet + $count < 0 || $lastOctet + $count > 255) {
                    throw new Exception(__("Last octet could be in range of 1 to 255", true));
                }

                for ($i=0; $i<$count; $i++) {
                    $ip = "$network." . ($lastOctet + $i);
                    if ($this->Ip->findByIp($ip)) {
                        throw new Exception(sprintf(
                            __("The IP address %s already belongs to somebody. Saving aborted", true), $ip));
                    }
                }

                for ($i=0; $i<$count; $i++) {
                    $ip = "$network." . ($lastOctet + $i);
                    $this->Ip->create();
                    $this->Ip->set(array('client_id'=>$clientId, 'ip'=>$ip));
                    if( !$this->Ip->save() ) {
                        throw new Exception(__('The ip could not be saved. Please, try again.', true));
                    }
                }
                $this->Session->setFlash(__('The ip addresses has been saved', true));
		        $this->redirect($this->Session->read('last_location'));
            }
        } catch (Exception $ex) {
            $this->Session->setFlash($ex->getMessage());
        }
        $this->set('client', $client);
    }

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ip', true));
			$this->redirect(array('action' => 'index'));
		}
        $ip = $this->Ip->findById($id);
        $this->set("ip", $ip);

        $macs = $this->Access->macs();
        $this->set("mac", isset($macs[$ip['Ip']['ip']]) ? 
            $macs[$ip['Ip']['ip']]['mac'] : "");

		if (!empty($this->data)) {
            if ($this->Ip->findByIp($this->data['Ip']['ip'])) {
				$this->Session->setFlash(__('The ip already belongs to another client.', true));
            } else {
                if ($this->Ip->save($this->data)) {
                    $this->Session->setFlash(__('The ip has been saved', true));
		            $this->redirect($this->Session->read('last_location'));
                } else {
                    $this->Session->setFlash(__('The ip could not be saved. Please, try again.', true));
                }
            }
		}
		if (empty($this->data)) {
			$this->data = $this->Ip->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ip', true));
			$this->redirect(array('action'=>'index'));
		}
        $ip = $this->Ip->findById($id);
		if ($this->Ip->delete($id)) {
			$this->Session->setFlash(__('Ip deleted', true));
		} else {
		    $this->Session->setFlash(__('Ip was not deleted', true));
        }
		$this->redirect($this->Session->read('last_location'));
	}

    function access($id, $action) {
        $ip = $this->Ip->read(null, $id);
        if ($ip) {
            if ($action == 'allow') {
                $this->Access->allow($ip['Ip']['ip']);
            } else {
                $this->Access->deny($ip['Ip']['ip']);
            }
        }

		$this->redirect($this->Session->read('last_location'));
    }
}
?>
