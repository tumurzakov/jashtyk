<?php
/* Configs Test cases generated on: 2010-09-02 11:09:14 : 1283406254*/
App::import('Controller', 'Configs');

class TestConfigsController extends ConfigsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ConfigsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.config', 'app.group');

	function startTest() {
		$this->Configs =& new TestConfigsController();
		$this->Configs->constructClasses();
	}

	function endTest() {
		unset($this->Configs);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>