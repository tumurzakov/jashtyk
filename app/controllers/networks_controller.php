<?php
class NetworksController extends AppController {

	var $name = 'Networks';

	function index() {
		$this->Network->recursive = 0;
		$this->set('networks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid network', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('network', $this->Network->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Network->create();
			if ($this->Network->save($this->data)) {
				$this->Session->setFlash(__('The network has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The network could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid network', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Network->save($this->data)) {
				$this->Session->setFlash(__('The network has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The network could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Network->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for network', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Network->delete($id)) {
			$this->Session->setFlash(__('Network deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Network was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
