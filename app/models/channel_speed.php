<?php
class ChannelSpeed extends AppModel {
    var $useTable = 'channel_speed';

    function getChartData($date, $chunk = 60) {
        $from = strtotime($date);
        $to = $from + 86400;

        $chart = array();

        for($i=$from; $i < $to; $i+= $chunk) {
            $chart[$i] = array('incoming'=>0, 'outgoing'=>0);
        }

        $sql = sprintf("
            SELECT chunk, SUM(global_in)*8 as global_in_sum, SUM(global_out)*8 AS global_out_sum FROM (
                SELECT time - time %% $chunk as chunk, `global_in`, `global_out` FROM {$this->table}
                WHERE (time BETWEEN %d AND %d)) as a GROUP BY chunk ORDER BY chunk", $from, $to );
        $traffic = $this->query($sql);

        foreach($traffic as $row) {
            $row_time = $row['a']['chunk'];
            $chart[$row_time]['incoming'] += $row[0]['global_in_sum']/$chunk/MEGABYTE;
            $chart[$row_time]['outgoing'] += $row[0]['global_out_sum']/$chunk/MEGABYTE;
        }

        return $chart;
    }

}
?>
