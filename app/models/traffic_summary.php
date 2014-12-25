<?php
App::import("Component", "Network");
class TrafficSummary extends AppModel {
    var $useTable = 'traffic_summary';
    var $belongsTo = 'Client';

    function afterFind($results, $primary) {
        for($i=0; $i<count($results); $i++) {
            if (isset($results[$i][$this->alias]) && isset($results[$i][$this->alias]['ip'])) {
                $results[$i][$this->alias]['ip_long'] = NetworkComponent::uint2int($results[$i][$this->alias]['ip']);
                $results[$i][$this->alias]['ip_uint'] = $results[$i][$this->alias]['ip'];
                $results[$i][$this->alias]['ip'] = long2ip($results[$i][$this->alias]['ip']);
            }
        }
        return $results;
    }

    function getGlobalTraffic($begin, $end) {
        $query = "SELECT sum(global_in + global_out) AS global_sum 
            FROM (traffic_summary a JOIN clients b on a.client_id = b.id) 
                JOIN client_types c ON b.client_type_id = c.id
            WHERE date >= '$begin' AND date < '$end'";
        $result = $this->query($query);
        if ($result) {
            return $result[0][0]['global_sum'];
        }
        return 0;
    }

    function getTrafficSummary($begin, $end, $clientId = null, $ip = 'all') {
        $conds = "";
        $conds .= $clientId == null ? "" : sprintf(" AND client_id = %d ", $clientId);
        $conds .= $ip == "all" ? "" : sprintf(" AND ip = INET_ATON('%s') ", $ip);

        $query = "SELECT client_id,
                SUM(global_in) as global_in_sum,
                SUM(global_out) as global_out_sum,
                SUM(peering_in) as peering_in_sum,
                SUM(peering_out) as peering_out_sum
            FROM traffic_summary
            WHERE date >= '$begin' AND date < '$end' $conds
            GROUP BY client_id";
        $clients = $this->query($query);

        $result = array();
        foreach($clients as $client) {
            $result[$client['traffic_summary']['client_id']] = $client[0];
        }
        return $result;
    }

    function getTrafficSummaryByDate($begin, $end, $clientId, $ip = 'all') {
        $conds = $ip == "all" ? "" : sprintf(" AND ip = INET_ATON('%s') ", $ip);

        $query = "SELECT date,
                SUM(global_in) as global_in_sum,
                SUM(global_out) as global_out_sum,
                SUM(peering_in) as peering_in_sum,
                SUM(peering_out) as peering_out_sum
            FROM traffic_summary
            WHERE date >= '$begin' AND date < '$end' AND client_id = $clientId $conds
            GROUP BY date";
        $clients = $this->query($query);

        $result = array();
        foreach($clients as $day) {
            $result[$day['traffic_summary']['date']] = $day[0];
        }
        return $result;
    }


    function update($ip, $statistic) {
        $ipDAO = ClassRegistry::init('Ip');
        $ip_str = long2ip($ip);
        $ip_uint = NetworkComponent::int2uint($ip);
        $clientId = $ipDAO->getClientIdByIp($ip_uint);

        if (!$clientId) {
            $this->log("Ip address not found $ip_str, skipping...");
            return;
        }

        $day = strftime("%F");

        $count = $this->find('count', array('conditions'=>array(
            'client_id'=>$clientId, 'date'=>$day, 'ip'=>$ip_uint)));

        if ($count == 0) {
            $this->create();
            $this->set(array(
                'client_id'=>$clientId, 'ip'=>$ip_uint, 'date'=>$day,
                'global_in'=>0, 'global_out'=>0, 'peering_in'=>0, 'peering_out'=>0));
            $this->save();
        }

        $sql = sprintf("UPDATE traffic_summary SET 
            global_in = global_in + %d, global_out = global_out + %d,
            peering_in = peering_in + %d, peering_out = peering_out + %d
            WHERE client_id = %d AND ip=$ip_uint AND date='%s'", 
            $statistic['global_in'], $statistic['global_out'], $statistic['peering_in'], $statistic['peering_out'],
            $clientId, $day);
        $this->query($sql);
    }
}
?>
