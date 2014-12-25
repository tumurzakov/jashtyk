<?php
class Peering extends AppModel {
    var $useTable = 'peering';

    function beforeSave($data) {
        if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $this->data[$this->alias]['network'])) {
            $this->data[$this->alias]['network'] = NetworkComponent::ip2long($this->data[$this->alias]['network']);
        }

        if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $this->data[$this->alias]['mask'])) {
            $this->data[$this->alias]['mask'] = NetworkComponent::ip2long($this->data[$this->alias]['mask']);
        }

        return true;
    }

    function afterFind($results, $primary) {
        for($i=0; $i<count($results); $i++) {
            if (isset($results[$i][$this->alias]) && isset($results[$i][$this->alias]['network'])) {
                $results[$i][$this->alias]['network_uint'] = $results[$i][$this->alias]['network'];
                $results[$i][$this->alias]['network_long'] = NetworkComponent::uint2int($results[$i][$this->alias]['network']);
                $results[$i][$this->alias]['network'] = long2ip($results[$i][$this->alias]['network']);
            }

            if (isset($results[$i][$this->alias]) && isset($results[$i][$this->alias]['mask'])) {
                $results[$i][$this->alias]['mask_long'] = NetworkComponent::uint2int($results[$i][$this->alias]['mask']);
                $results[$i][$this->alias]['mask_uint'] = $results[$i][$this->alias]['mask'];
                $results[$i][$this->alias]['mask'] = long2ip($results[$i][$this->alias]['mask']);
            }
        }
        return $results;
    }

    function exist($ip, $mask) {
        $count = $this->find('count', array('conditions'=>array(
            'network'=>$ip, 'mask'=>$mask)));
        return $count > 0;
    }

    function add($name, $ip, $mask) {
        $this->create();
        $this->set(array('network'=>$ip, 'mask'=>$mask, 'description'=>$name));
        $this->save();
    }

}
?>
