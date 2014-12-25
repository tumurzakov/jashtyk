<?php
App::import('Model', 'TrafficDetail');
App::import('Model', 'TrafficSummary');

class TrafficComponent extends Object {
    function TrafficComponent($controller) {
        $this->TrafficDetail = ClassRegistry::init('TrafficDetail');
        $this->TrafficSummary = ClassRegistry::init('TrafficSummary');
    }

    function update($ip, $stats) {
        $this->TrafficDetail->add($ip, $globalIn, $globalOut, $peeringIn, $peeringOut, $time);
    }
}
?>
