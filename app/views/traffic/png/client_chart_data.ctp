<?php
$this->Graph->network(array(
    'time'=>$chart['time'],
    'incoming'=>$chart['incoming'],
    'outgoing'=>$chart['outgoing'],
), sprintf("Bandwidth usage chart for %s [ date: %s, ip: %s ]", 
    $client['Client']['name'], $date, empty($ip) ? "all" : $ip));
