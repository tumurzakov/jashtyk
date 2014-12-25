<?php
App::import("Model", "Config");

class ConfigTest extends Config {
    var $name = 'Config';
    var $useDbConfig = 'test';
}

class ConfigTestCase extends CakeTestCase {
    var $fixtures = array('app.config_test');

    function startTest() {
        ClassRegistry::init('ConfigTest'); 
        $this->model = new ConfigTest();
    }

    function testGet() {
        $this->assertEqual(1, $this->model->get('max_processing_count'));
    }

    function testGetNotFound() {
        try {
            $this->model->get('other');
            $this->assertTrue(false);
        } catch(Exception $ex) {
            $this->assertEqual("Config variable not found", $ex->getMessage());
        }
    }
}
?>
