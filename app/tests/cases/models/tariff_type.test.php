<?php
/* TariffType Test cases generated on: 2010-12-28 16:12:49 : 1293533209*/
App::import('Model', 'TariffType');

class TariffTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.tariff_type');

	function startTest() {
		$this->TariffType =& ClassRegistry::init('TariffType');
	}

	function endTest() {
		unset($this->TariffType);
		ClassRegistry::flush();
	}

}
?>