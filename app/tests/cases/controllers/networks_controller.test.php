<?php
/* Networks Test cases generated on: 2010-08-26 16:08:02 : 1282818482*/
App::import('Controller', 'Networks');

class TestNetworksController extends NetworksController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class NetworksControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.network');

	function startTest() {
		$this->Networks =& new TestNetworksController();
		$this->Networks->constructClasses();
	}

	function endTest() {
		unset($this->Networks);
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