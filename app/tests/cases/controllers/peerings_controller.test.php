<?php
/* Peerings Test cases generated on: 2010-08-26 16:08:45 : 1282817205*/
App::import('Controller', 'Peerings');

class TestPeeringsController extends PeeringsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PeeringsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.peering');

	function startTest() {
		$this->Peerings =& new TestPeeringsController();
		$this->Peerings->constructClasses();
	}

	function endTest() {
		unset($this->Peerings);
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