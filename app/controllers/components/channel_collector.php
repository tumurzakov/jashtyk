<?php
App::import('Model', 'ChannelSpeed');
App::import('Component', 'Network');
class ChannelCollectorComponent extends Object {
    function ChannelCollectorComponent() {
        $this->Network = new NetworkComponent(null);
        $this->ChannelSpeed = ClassRegistry::init('ChannelSpeed');
        $this->stat = array('global_in'=>0, 'global_out'=>0, 'peering_in'=>0, 'peering_out'=>0);
    }

    function add($row, $options) {
        $src = ip2long($row[1]); 
        $dst = ip2long($row[2]); 
        $bytes = $row[4];

        if (!isset($this->stat['time'])) $this->stat['time'] = strtotime($options['time']);

        $isSrcBelongsToBilling = $this->Network->isBillingIp($src);
        $isDstBelongsToBilling = $this->Network->isBillingIp($dst);

        if ($isSrcBelongsToBilling && $isDstBelongsToBilling) {
            return;
        }

        if ($isSrcBelongsToBilling) {
            if ($this->Network->isPeeringIp($dst)) {
                $this->stat['peering_out'] += $bytes;
            } else {
                $this->stat['global_out'] += $bytes;
            }
        }
        if ($isDstBelongsToBilling) {
            if ($this->Network->isPeeringIp($src)) {
                $this->stat['peering_in'] += $bytes;
            } else {
                $this->stat['global_in'] += $bytes;
            }
        }
    }

    function persist() {
        $this->ChannelSpeed->create();
        $this->ChannelSpeed->set(array('ChannelSpeed'=>$this->stat));
        $this->ChannelSpeed->save();
    }
}
?>
