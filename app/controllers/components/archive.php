<?php
App::import('Model', 'Config');
App::import('Component', 'System');
App::import('Component', 'Date');

class ArchiveComponent extends Object {

    function ArchiveComponent() {
        $this->Config = ClassRegistry::init('Config');
        $this->System = new SystemComponent();
        $this->Date = new DateComponent();
    }

    function createDetailRequestDir($id) {
        $archive = $this->Config->get('archive_dir');
        $dir = "$archive/detail-request-$id";

        if (file_exists($dir)) {
            throw new Exception("Request directory already exist");
        }

        if (!mkdir($dir)) {
            throw new Exception("Creating request temporary directory failed");
        }
        return $dir;
    }

    function decompressDetailFileToDir($file, $archive, $dir) {
        $archiveDir = $this->Config->get('archive_dir');
        $unzip = $this->Config->get('unzip');
        $copy = $this->Config->get('copy');

        if ($archive == strftime("%Y-%m-%d", $this->Date->now())) {
            $this->System->run("$copy $archiveDir/$archive/$file $dir");
        } else {
            $result = $this->System->run("$unzip $archiveDir/$archive.zip $file -d $dir");
            if (preg_match('/filename not matched/', $result)) {
                return false;
            }
        }

        rename("$dir/$file", "$dir/$archive");
        return "$dir/$archive";
    }

    function compressDetailRequestResult($dir) {
        $zip = $this->Config->get('zip');
        $rm = $this->Config->get('rm');
        $resultDir = $this->Config->get('detail_request_result_dir');

        $result = $this->System->run("$zip -jr $dir.zip $dir");

        rename("$dir.zip", $resultDir."/".basename("$dir.zip"));
        $this->System->run("$rm -rf $dir");
        return $resultDir."/".basename("$dir.zip");
    }

    function clearDetailRequest($dir) {
        $rm = $this->Config->get('rm');
        $this->System->run("$rm -rf $dir");
    }
}
?>
