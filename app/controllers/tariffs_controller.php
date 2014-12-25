<?php
class TariffsController extends AppController {

	var $name = 'Tariffs';

	function index() {
		$this->Tariff->recursive = 0;
		$this->set('tariffs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tariff', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('tariff', $this->Tariff->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Tariff->create();
			if ($this->Tariff->save($this->data)) {
				$this->Session->setFlash(__('The tariff has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tariff could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tariff', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tariff->save($this->data)) {
				$this->Session->setFlash(__('The tariff has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tariff could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tariff->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tariff', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tariff->delete($id)) {
			$this->Session->setFlash(__('Tariff deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tariff was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
