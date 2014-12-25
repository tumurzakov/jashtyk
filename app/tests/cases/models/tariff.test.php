<?php
/* Tariff Test cases generated on: 2010-12-28 16:12:04 : 1293532504*/
App::import('Model', 'Tariff');

class TariffTestCase extends CakeTestCase {
	var $fixtures = array('app.tariff');

	function startTest() {
		$this->Tariff =& ClassRegistry::init('Tariff');
	}

	function endTest() {
		unset($this->Tariff);
		ClassRegistry::flush();
	}

}
?>