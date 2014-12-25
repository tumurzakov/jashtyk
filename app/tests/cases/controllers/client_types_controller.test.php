<?php
/* ClientTypes Test cases generated on: 2010-08-20 14:08:17 : 1282293677*/
App::import('Controller', 'ClientTypes');

class TestClientTypesController extends ClientTypesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ClientTypesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.client_type');

	function startTest() {
		$this->ClientTypes =& new TestClientTypesController();
		$this->ClientTypes->constructClasses();
	}

	function endTest() {
		unset($this->ClientTypes);
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