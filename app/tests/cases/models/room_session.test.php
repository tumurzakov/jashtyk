<?php
/* RoomSession Test cases generated on: 2010-12-29 11:12:56 : 1293600776*/
App::import('Model', 'RoomSession');

class RoomSessionTestCase extends CakeTestCase {
	var $fixtures = array('app.room_session', 'app.client', 'app.client_type', 'app.ip', 'app.tariff', 'app.tariff_type');

	function startTest() {
		$this->RoomSession =& ClassRegistry::init('RoomSession');
	}

	function endTest() {
		unset($this->RoomSession);
		ClassRegistry::flush();
	}

}
?>