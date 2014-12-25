<?php
class ConfigsController extends AppController {
    var $uses = array('Config');
	var $name = 'Configs';

	function index() {
		$this->Config->recursive = 0;
		$this->set('configs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid config', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('config', $this->Config->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Config->create();
			if ($this->Config->save($this->data)) {
				$this->Session->setFlash(__('The config has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The config could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid config', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Config->save($this->data)) {
				$this->Session->setFlash(__('The config has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The config could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Config->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for config', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Config->delete($id)) {
			$this->Session->setFlash(__('Config deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Config was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function settings() {
        $configs = $this->Config->find('all');
        $configs[] = array('Config'=>array('name'=>'base', 'value'=>$this->base));
        $this->set('configs', $configs);
    }
}
?>
