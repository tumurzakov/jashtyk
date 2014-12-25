<?php
/* Ips Test cases generated on: 2010-08-20 14:08:43 : 1282293703*/
App::import('Controller', 'Ips');

class TestIpsController extends IpsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class IpsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.ip', 'app.client', 'app.user', 'app.group', 'app.client_type');

	function startTest() {
		$this->Ips =& new TestIpsController();
		$this->Ips->constructClasses();
	}

	function endTest() {
		unset($this->Ips);
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