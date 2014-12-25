<?php
App::import('Model', 'DetailRequest');
App::import('Model', 'Config');
App::import('Component', 'Detail');
App::import('Component', 'Archive');

Mock::generate('DetailRequest');
Mock::generate('Config');
Mock::generate('ArchiveComponent');

class DetailTestCase extends CakeTestCase {
    function startTest() {
        $this->component = new DetailComponent();
        $this->component->DetailRequest = new MockDetailRequest();
        $this->component->Config = new MockConfig();
        $this->component->Archive = new MockArchiveComponent();
    }

    function testCheckProcessAllowed() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));
        $this->assertTrue($this->component->checkProcessAllowed());
    }

    function testCheckProcessAllowedOverflow() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 1, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));
        $this->assertFalse($this->component->checkProcessAllowed());
    }

    function testProcess() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));

        $this->component->DetailRequest->setReturnValue('getFirstAccepted', 
            array('DetailRequest'=>array('id'=>1, 'ip'=>'212.112.96.1', 'from'=>'2010-01-01', 'to'=>'2010-01-02')),
            array());

        $this->component->DetailRequest->expectAt(0, 'setStatus', array(1, 'processing'));

        $dir = '/tmp/detail-request-1';
        $this->component->Archive->setReturnValue('createDetailRequestDir', $dir, array(1));
        $this->component->Archive->setReturnValue('decompressDetailFileToDir', "$dir/2010-01-01", array('212.112.96.1', "2010-01-01", $dir));
        $this->component->Archive->expectOnce('decompressDetailFileToDir', array('212.112.96.1', "2010-01-01", $dir));
        $this->component->Archive->setReturnValue('compressDetailRequestResult', "$dir.zip", array($dir));
        $this->component->Archive->expectOnce('compressDetailRequestResult', array($dir));

        $this->component->DetailRequest->expectAt(1, 'setStatus', array(1, 'completed', array('file'=>"$dir.zip")));

        $this->component->process();
    }

    function testProcessCanceled() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));

        $this->component->DetailRequest->setReturnValue('getFirstAccepted', 
            array('DetailRequest'=>array('id'=>1, 'ip'=>'212.112.96.1', 'from'=>'2010-01-01', 'to'=>'2010-01-02')),
            array());

        $this->component->DetailRequest->expectAt(0, 'setStatus', array(1, 'processing'));

        $dir = '/tmp/detail-request-1';
        $this->component->Archive->setReturnValue('createDetailRequestDir', $dir, array(1));
        $this->component->DetailRequest->setReturnValue('checkIfCanceled', true, array(1));
        $this->component->DetailRequest->expectAt(1, 'setStatus', array(1, 'canceled'));
        $this->component->Archive->expectOnce('clearDetailRequest', array($dir));

        $this->component->process();
    }


    function testProcessStatisticNotFound() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));

        $this->component->DetailRequest->setReturnValue('getFirstAccepted', 
            array('DetailRequest'=>array('id'=>1, 'ip'=>'212.112.96.1', 'from'=>'2010-01-01', 'to'=>'2010-01-02')),
            array());

        $this->component->DetailRequest->expectAt(0, 'setStatus', array(1, 'processing'));

        $dir = '/tmp/detail-request-1';
        $this->component->Archive->setReturnValue('createDetailRequestDir', $dir, array(1));
        $this->component->Archive->setReturnValue('decompressDetailFileToDir', false, array('212.112.96.1', "2010-01-01", $dir));

        $this->component->DetailRequest->expectAt(1, 'setStatus', array(1, 'failed', array('description'=>"There is no statistic for given parameters")));
        $this->component->Archive->expectOnce('clearDetailRequest', array($dir));

        $this->component->process();
    }


    function testProcessNoAccepted() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));

        $this->component->DetailRequest->setReturnValue('getFirstAccepted', null, array());
        $this->component->DetailRequest->expectNever('setStatus', array(1, 'processing'));
        $this->component->process();
    }

    function testProcessDirectoryExist() {
        $this->component->DetailRequest->setReturnValue('getCountByStatus', 0, array('processing'));
        $this->component->Config->setReturnValue('get', 1, array('max_processing_count'));

        $this->component->DetailRequest->setReturnValue('getFirstAccepted', 
            array('DetailRequest'=>array('id'=>1, 'ip'=>'212.112.96.1', 'from'=>'2010-01-01', 'to'=>'2010-01-02')),
            array());

        $this->component->DetailRequest->expectAt(0, 'setStatus', array(1, 'processing'));
        $dir = '/tmp/detail-request-1';
        $this->component->Archive->throwOn('createDetailRequestDir', new Exception("Directory already exist"));
        $this->component->DetailRequest->expectAt(1, 'setStatus', array(1, 'failed', array('description'=>"Directory already exist")));
        $this->component->process();
    }

}
?>
