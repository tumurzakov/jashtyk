<?php
class PeeringsController extends AppController {
    var $components = array('Network');
	var $name = 'Peerings';

	function index() {
		$this->Peering->recursive = 0;
		$this->set('peerings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid peering', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('peering', $this->Peering->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Peering->create();
			if ($this->Peering->save($this->data)) {
				$this->Session->setFlash(__('The peering has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The peering could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid peering', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Peering->save($this->data)) {
				$this->Session->setFlash(__('The peering has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The peering could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Peering->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for peering', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Peering->delete($id)) {
			$this->Session->setFlash(__('Peering deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Peering was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function update() {
        $html = file_get_contents("http://www.elcat.kg/ip/kg-nets-isp.txt");
        $lines = explode("\n", $html);

        foreach($lines as $line) {
            if (preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\/[0-9]{2}) ([A-Z0-9-]+)/', $line, $matches)) {
                $network = $this->Network->parseCidr($matches[1]);
                if (!empty($network) && !$this->Peering->exist($network['network_uint'], $network['mask_uint'])) {
                    $this->Peering->add($matches[2], $network['network_uint'], $network['mask_uint']);
                }
            }
        }
		$this->redirect(array('action' => 'index'));
    }
}
?>
