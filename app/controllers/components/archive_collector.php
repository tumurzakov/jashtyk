<?php
App::import('Model', 'Config');
App::import('Component', 'Network');

class ArchiveCollectorComponent extends Object {
    function ArchiveCollectorComponent() {
        $this->Config = ClassRegistry::init('Config');
        $this->Network = new NetworkComponent;
        $this->stat = array();
    }

    function add($row, $options) {
        $line = $options['time'] . "\t" . $row[0] . "\n";

        $src = ip2long($row[1]); 
        $dst = ip2long($row[2]);

        $isSrcBelongsToBilling = $this->Network->isBillingIp($src);
        $isDstBelongsToBilling = $this->Network->isBillingIp($dst);

        if ($isSrcBelongsToBilling && $isDstBelongsToBilling) {
            return;
        }

        if ($isSrcBelongsToBilling) {
            $this->stat[$src][] = $line;
        }
        
        if ($isDstBelongsToBilling) {
            $this->stat[$dst][] = $line;
        }

        if (!$isSrcBelongsToBilling && !$isDstBelongsToBilling) {
            $this->stat['unknown'][] = $line;
        }
    }

    function persist() {
        $dir =  $this->Config->get('archive_dir', '.') . "/" . strftime('%Y-%m-%d');

        if (!file_exists($dir)) {
            mkdir($dir);
        }
        foreach($this->stat as $ipLong=>$statistic) {
            $ip = long2ip($ipLong);
            if($fp = fopen("$dir/$ip", 'a+')) {
                fwrite($fp, join($statistic));
                fclose($fp);
            }
        }
    }
}
?>
