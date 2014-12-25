<?php
$this->Graph->network(array(
    'time'=>$chart['time'],
    'incoming'=>$chart['incoming'],
    'outgoing'=>$chart['outgoing'],
), sprintf("Overal Channel Bandwidth usage chart [ date: %s ]", $date));
