<?php
/* TariffTypes Test cases generated on: 2010-12-28 16:12:19 : 1293533239*/
App::import('Controller', 'TariffTypes');

class TestTariffTypesController extends TariffTypesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TariffTypesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.tariff_type', 'app.group');

	function startTest() {
		$this->TariffTypes =& new TestTariffTypesController();
		$this->TariffTypes->constructClasses();
	}

	function endTest() {
		unset($this->TariffTypes);
		ClassRegistry::flush();
	}

}
?>