<?php
App::import('Model', 'DetailRequest');
App::import('Model', 'Config');
App::import('Component', 'Archive');
App::import('Component', 'Analyze');

class DetailComponent extends Object {
    function DetailComponent() {
        $this->Config = ClassRegistry::init('Config');
        $this->DetailRequest = ClassRegistry::init('DetailRequest');
        $this->Archive = new ArchiveComponent();
        $this->Analyze = new AnalyzeComponent();
    }

    function checkProcessAllowed() {
        return $this->DetailRequest->getCountByStatus('processing') < $this->Config->get('max_processing_count');
    }

    function process() {
        if ($this->checkProcessAllowed()) {
            $accepted = $this->DetailRequest->getFirstAccepted();
            try {
                if ($accepted) {
                    $this->DetailRequest->setStatus($accepted['DetailRequest']['id'], 'processing');

                    $begin = strtotime($accepted['DetailRequest']['from']);
                    $end = strtotime($accepted['DetailRequest']['to']);

                    $dir = $this->Archive->createDetailRequestDir($accepted['DetailRequest']['id']);
                    $statisticFound = false;
                    $files = array();
                    while($begin < $end) {
                        if ($this->DetailRequest->checkIfCanceled($accepted['DetailRequest']['id'])) {
                            $this->DetailRequest->setStatus($accepted['DetailRequest']['id'], 'canceled');
                            $this->Archive->clearDetailRequest($dir);
                            return;
                        }
                        $file = $this->Archive->decompressDetailFileToDir(
                            $accepted['DetailRequest']['ip'], strftime("%Y-%m-%d", $begin), $dir);
                        $files[] = $file;
                        $statisticFound = $statisticFound || $file;
                        $begin += 86400;
                    }
                    if (!$statisticFound) throw new Exception("There is no statistic for given parameters");
                    $this->Analyze->process($accepted['DetailRequest']['ip'], $files, "$dir/statistic.txt");
                    $file = $this->Archive->compressDetailRequestResult($dir);

                    $this->DetailRequest->setStatus($accepted['DetailRequest']['id'], 'completed', array('file'=>$file));
                }
            } catch (Exception $ex) {
                $this->DetailRequest->setStatus($accepted['DetailRequest']['id'], 'failed', array('description'=>$ex->getMessage()));
                if (isset($dir)) $this->Archive->clearDetailRequest($dir);
            }
        }
    }
}
?>
