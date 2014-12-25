<?php
/* Tariffs Test cases generated on: 2010-12-28 16:12:52 : 1293532552*/
App::import('Controller', 'Tariffs');

class TestTariffsController extends TariffsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TariffsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.tariff', 'app.group');

	function startTest() {
		$this->Tariffs =& new TestTariffsController();
		$this->Tariffs->constructClasses();
	}

	function endTest() {
		unset($this->Tariffs);
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