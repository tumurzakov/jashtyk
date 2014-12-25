<?php
App::import('Model', 'TrafficDetail');
App::import('Model', 'TrafficSummary');
App::import('Model', 'RoomSession');
App::import('Component', 'Network');

class TrafficCollectorComponent extends Object {
    function TrafficCollectorComponent() {
        $this->TrafficDetail = ClassRegistry::init('TrafficDetail');
        $this->TrafficSummary = ClassRegistry::init('TrafficSummary');
        $this->RoomSession = ClassRegistry::init('RoomSession');
        $this->Network = new NetworkComponent;
        $this->stat = array();
    }

    function add($row, $options) {
        $src = ip2long($row[1]); 
        $dst = ip2long($row[2]); 
        $bytes = $row[4];

        $isSrcBelongsToBilling = $this->Network->isBillingIp($src);
        $isDstBelongsToBilling = $this->Network->isBillingIp($dst);

        if ($isSrcBelongsToBilling && $isDstBelongsToBilling) {
            return;
        }

        if ($isSrcBelongsToBilling) {
            $this->initIp($src, $options['time']);

            if ($this->Network->isPeeringIp($dst)) {
                $this->stat[$src]['peering_out'] += $bytes;
            } else {
                $this->stat[$src]['global_out'] += $bytes;
            }
        }
        
        if ($isDstBelongsToBilling) {
            $this->initIp($dst, $options['time']);

            if ($this->Network->isPeeringIp($src)) {
                $this->stat[$dst]['peering_in'] += $bytes;
            } else {
                $this->stat[$dst]['global_in'] += $bytes;
            }
        }
    }

    function persist() {
        foreach($this->stat as $ip=>$statistic) {
            $this->TrafficDetail->add($ip, $statistic);
            $this->TrafficSummary->update($ip, $statistic);
            $this->RoomSession->update($ip, $statistic);
        }
    }

    private function initIp($ip, $time) {
        if (!isset($this->stat[$ip])) $this->stat[$ip] = 
            array('global_in'=>0, 'global_out'=>0, 'peering_in'=>0, 'peering_out'=>0, 'time'=>$time, 'ip'=>$ip);
    }
}
?>
