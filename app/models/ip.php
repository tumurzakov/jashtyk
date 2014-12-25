<?php
App::import('Component', 'Network');
class Ip extends AppModel {
    var $belongsTo = 'Client';
    var $clientHash = array();

    function afterFind($results, $primary) {
        for($i=0; $i<count($results); $i++) {
            if (isset($results[$i][$this->alias]) && isset($results[$i][$this->alias]['ip'])) {
                $results[$i][$this->alias]['ip_uint'] = $results[$i][$this->alias]['ip'];
                $results[$i][$this->alias]['ip_long'] = NetworkComponent::uint2int($results[$i][$this->alias]['ip']);
                $results[$i][$this->alias]['ip'] = long2ip($results[$i][$this->alias]['ip']);
            }
        }
        return $results;
    }

    function beforeSave($options) {
        if (!empty($this->data[$this->alias]['ip'])) {
            $this->data[$this->alias]['ip'] = NetworkComponent::ip2long($this->data[$this->alias]['ip']);
        }
        return true;
    }

    function getClientIdByIp($ip) {
        if (empty($this->clientHash)) {
            $list = $this->find('all', array('fields'=>array('ip', 'client_id')));
            foreach($list as $row) {
                $this->clientHash[NetworkComponent::ip2long($row['Ip']['ip'])] = $row['Ip']['client_id'];
            }
        }

        return isset($this->clientHash[$ip]) ? $this->clientHash[$ip] : 0;
    }
}
?>
