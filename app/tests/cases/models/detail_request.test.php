<?php
App::import("Model", "DetailRequest");

class DetailRequestTest extends DetailRequest{
    var $name = 'DetailRequest';
    var $useDbConfig = 'test';
}

class DetailRequestTestCase extends CakeTestCase {
    var $fixtures = array('app.detail_request_test');

    function startCase() {
        ClassRegistry::init('DetailRequestTest'); 
        $this->model = new DetailRequestTest();
    }

    function testSetStatus() {
        $this->model->setStatus(1, 'canceling');

        $request = $this->model->findById(1);
        $this->assertEqual('canceling', $request['DetailRequest']['status']);
    }

    function testSetStatusProcessing() {
        $this->model->setStatus(1, 'processing');
        $request = $this->model->findById(1);
        $this->assertEqual('processing', $request['DetailRequest']['status']);
        $this->assertNotNull($request['DetailRequest']['started']);
    }

    function testSetStatusCompleted() {
        $this->model->setStatus(1, 'completed', array('file'=>'file'));
        $request = $this->model->findById(1);
        $this->assertEqual('completed', $request['DetailRequest']['status']);
        $this->assertNotNull($request['DetailRequest']['completed']);
        $this->assertEqual('file', $request['DetailRequest']['file']);
    }

    function testGetCountByStatus() {
        $this->assertEqual(1, $this->model->getCountByStatus('processing'));
    }

    function testGetFirstAccepted() {
        $accepted = $this->model->getFirstAccepted();
        $this->assertEqual(1, $accepted['DetailRequest']['id']);
    }
}
?>
