<?php
/* RoomSessions Test cases generated on: 2010-12-29 13:12:56 : 1293608936*/
App::import('Controller', 'RoomSessions');

class TestRoomSessionsController extends RoomSessionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RoomSessionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.room_session', 'app.client', 'app.client_type', 'app.ip', 'app.tariff', 'app.tariff_type', 'app.group');

	function startTest() {
		$this->RoomSessions =& new TestRoomSessionsController();
		$this->RoomSessions->constructClasses();
	}

	function endTest() {
		unset($this->RoomSessions);
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