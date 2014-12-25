<?php
App::import('Component', 'Network');
class TrafficDetail extends AppModel {
    var $belongsTo = 'Client';

    function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

        foreach(array('yesterday', 'today', 'tomorrow') as $day) {
            $tableName = strftime("z%Yx%mx%d", strtotime($day));
            if (!$this->tableExist($tableName)) {
                $this->createTable($tableName);
            }
        }
    }

    function beforeSave($data) {
        if (gettype($this->data[$this->alias]['ip']) == "integer") {
            $this->data[$this->alias]['ip'] = NetworkComponent::int2uint($this->data[$this->alias]['ip']);
        } else if (preg_match('/\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}/', $this->data[$this->alias]['ip'])) {
            $this->data[$this->alias]['ip'] = NetworkComponent::ip2long($this->data[$this->alias]['ip']);
        }
        return true;
    }

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

    function setDate($date) {
        $this->table = strftime("z%Yx%mx%d", strtotime($date));
    }

    function tableExist($table) {
        if (preg_match('/\d{4}-\d{2}-\d{2}/', $table)) {
            $table = strftime("z%Yx%mx%d", strtotime($table));
        }
        return count($this->query("show tables like '$table'")) > 0;
    }

    function createTable($table) {
        $this->query("
            CREATE TABLE IF NOT EXISTS `$table` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `client_id` int(10) NOT NULL,
              `ip` bigint(30) NOT NULL,
              `time` bigint(30) NOT NULL,
              `global_in` bigint(30) NOT NULL,
              `global_out` bigint(30) NOT NULL,
              `peering_in` bigint(30) NOT NULL,
              `peering_out` bigint(30) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ");

        $this->query("CREATE INDEX {$table}_idx ON $table (client_id, ip, time)");
    }

    function getClientTrafficChartData($clientId, $date, $ip=null, $chunk=60) {
        $from = strtotime($date);
        $to = $from + 86400;
        $table = strftime("z%Yx%mx%d", $from);

        $chart = array();

        for($i=$from; $i < $to; $i+= $chunk) {
            $chart[$i] = array('incoming'=>0, 'outgoing'=>0);
        }

        if ($this->tableExist($table)) {
            $sql = sprintf("
                SELECT chunk, SUM(global_in)*8 as global_in_sum, SUM(global_out)*8 AS global_out_sum FROM (
                    SELECT time - time %% $chunk as chunk, `global_in`, `global_out` FROM $table
                    WHERE client_id = %d AND (time BETWEEN %d AND %d) %s) as a GROUP BY chunk ORDER BY chunk", 
                $clientId, $from, $to, ($ip == "all" || empty($ip)) ? "" : " AND ip = ".NetworkComponent::ip2long($ip));
            $traffic = $this->query($sql);

            foreach($traffic as $row) {
                $row_time = $row['a']['chunk'];
                $chart[$row_time]['incoming'] += $row[0]['global_in_sum']/$chunk/MEGABYTE;
                $chart[$row_time]['outgoing'] += $row[0]['global_out_sum']/$chunk/MEGABYTE;
            }
        }

        return $chart;
    }

    function add($ip, $statistic) {
        $ipDAO = ClassRegistry::init('Ip');
        $ip_str = long2ip($ip);
        $ip_uint = NetworkComponent::int2uint($ip);
        $clientId = $ipDAO->getClientIdByIp($ip_uint);
        $this->table = strftime("z%Yx%mx%d", strtotime($statistic['time']));
        $statistic['time'] = strtotime($statistic['time']);

        if ($clientId) {
            $this->create();
            $this->set(array_merge($statistic, array('client_id'=>$clientId)));
            $this->save();
        } else {
            $this->log("Ip address not found $ip_str, skipping...");
        }
            
    }
}
?>
