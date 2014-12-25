<?php
App::import('Model', 'Config');
App::import('Component', 'Archive');
App::import('Component', 'System');

Mock::generate('Config');

class ArchiveTestCase extends CakeTestCase {
    function startTest() {
        $this->component = new ArchiveComponent();
        $this->component->Config = new MockConfig();
        $this->component->System = new SystemComponent();
    }

    function testCreateDetailRequestDir() {
        $dir = '/tmp/detail-request-1';
        if (file_exists($dir)) system("rm -rf $dir");
        $this->component->Config->setReturnValue('get', '/tmp', array('archive_dir'));
        $this->assertEqual($dir, $this->component->createDetailRequestDir(1));
        $this->assertTrue(file_exists($dir));
        rmdir($dir);
    }

    function testCreateDetailRequestDirExist() {
        $this->component->Config->setReturnValue('get', '/tmp', array('archive_dir'));

        $dir = '/tmp/detail-request-1';
        if (file_exists($dir)) system("rm -rf $dir"); mkdir($dir);
        try {
            $this->assertEqual($dir, $this->component->createDetailRequestDir(1));
            $this->assertTrue(false);
        } catch (Exception $ex) { 
            $this->assertEqual("Request directory already exist", $ex->getMessage());
        }
        rmdir($dir);
    }

    function testDecompressDetailFileToDir() {
        $dir = '/tmp/detail-request-1';
        if (file_exists($dir)) system("rm -rf $dir"); mkdir($dir);
        touch("$dir/212.112.96.1");
        system("zip -j $dir/2010-01-01.zip $dir/212.112.96.1 >> /dev/null");
        unlink("$dir/212.112.96.1");

        $this->component->Config->setReturnValue('get', $dir, array('archive_dir'));
        $this->component->Config->setReturnValue('get', 'unzip', array('unzip'));
        $this->assertEqual("$dir/2010-01-01", $this->component->decompressDetailFileToDir('212.112.96.1', '2010-01-01', $dir));

        $this->assertTrue(file_exists("$dir/2010-01-01"));
        system("rm -rf $dir");
    }

    function testDecompressDetailFileToDirInvalidFormat() {
        $dir = '/tmp/detail-request-1';
        if (file_exists($dir)) system("rm -rf $dir"); mkdir($dir);
        touch("$dir/212.112.96.1");
        system("zip $dir/2010-01-01.zip $dir/212.112.96.1 >> /dev/null");
        unlink("$dir/212.112.96.1");

        $this->component->Config->setReturnValue('get', $dir, array('archive_dir'));
        $this->component->Config->setReturnValue('get', 'unzip', array('unzip'));
        $this->assertFalse($this->component->decompressDetailFileToDir('212.112.96.1', '2010-01-01', $dir));
        system("rm -rf $dir");
    }

    function testCompressDetailRequestResult() {
        $dir = '/tmp/detail-request-1';
        if (file_exists($dir)) system("rm -rf $dir"); mkdir($dir);
        touch("$dir/2010-01-01");

        $this->component->Config->setReturnValue('get', 'rm', array('rm'));
        $this->component->Config->setReturnValue('get', 'zip', array('zip'));
        $this->component->Config->setReturnValue('get', '/tmp', array('detail_request_result_dir'));
        $this->component->compressDetailRequestResult($dir);

        $this->assertTrue(file_exists("$dir.zip"));
        $this->assertTrue(!file_exists($dir));

        unlink("$dir.zip");
    }
}
?>
