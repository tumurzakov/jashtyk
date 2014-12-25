<?php
App::import('Component', 'Access');
class Client extends AppModel {
    var $belongsTo = array('ClientType');
    var $hasMany = array('Ip'=>array('className'=>'Ip', 'dependent'=> true, 'order'=>'ip'));

    function getFeeSumOfBandwidthClients() {
        $result = $this->query(
            "SELECT sum(fee) 
            FROM clients JOIN client_types ON clients.client_type_id = client_types.id 
            WHERE client_types.name = 'By bandwidth'");
        if ($result) {
            return $result[0][0]['sum'];
        }
        return 0;
    }

    function getClientListWithType() {
        $result = $this->query(
            "SELECT clients.id, clients.name, clients.fee, client_types.name AS type
            FROM clients JOIN client_types ON clients.client_type_id = client_types.id ORDER BY client_types.name DESC, clients.name");
        return $result;
    }

    function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        if (isset($extra['pattern'])) {
            $pattern = $extra['pattern'];
            $sql = "SELECT clients.id FROM clients LEFT JOIN ips ON clients.id = ips.client_id
                WHERE clients.name LIKE '%$pattern%' OR INET_ATON(ips.ip) LIKE '%$pattern%' GROUP BY clients.id";
        } else {
            $sql = "SELECT id FROM clients";
        }
        $this->recursive = $recursive;
        $results = $this->query($sql);
        return count($results);
    }

    function allow($clientId) {
        $access = new AccessComponent(null);
        $client = $this->read(null, $clientId);
        foreach($client['Ip'] as $ip) $access->allow($ip['ip']);
    }

    function deny($clientId) {
        $access = new AccessComponent(null);
        $client = $this->read(null, $clientId);
        foreach($client['Ip'] as $ip) $access->deny($ip['ip']);
    }

    function getStatus($clientId) {
        static $status = null; 
        if ($status == null) {
            $access = new AccessComponent(null);
            $status = $access->status();
        }

        $client = $this->read(null, $clientId);
        foreach($client['Ip'] as $ip) {
            if (isset($status["{$ip['ip']}/32"])) return 'on';
        }
        return 'off';
    }
}
?>
