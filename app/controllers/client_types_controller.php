<?php
class ClientTypesController extends AppController {

	var $name = 'ClientTypes';

	function index() {
		$this->ClientType->recursive = 0;
		$this->set('clientTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid client type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('clientType', $this->ClientType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ClientType->create();
			if ($this->ClientType->save($this->data)) {
				$this->Session->setFlash(__('The client type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid client type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ClientType->save($this->data)) {
				$this->Session->setFlash(__('The client type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ClientType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for client type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ClientType->delete($id)) {
			$this->Session->setFlash(__('Client type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Client type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
