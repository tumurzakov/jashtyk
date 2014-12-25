<?php
App::import('Model', 'ChannelSpeed');

class ChannelSpeedController extends AppController {
    var $uses = array('ChannelSpeed');
    var $components = array('Date');
    var $helpers = array('Graph');

    function index() {
    }

    function channel_speed_data($date = null) {
        $date = $date == null ? strftime("%F", $this->Date->now()) : $date;

        $data = $this->ChannelSpeed->getChartData($date, 300);

        $chart = array( 'time'=>array(), 'incoming'=>array(), 'outgoing'=>array());
        foreach($data as $time => $row) {
            $chart['time'][] = strftime("%H:%M", $time);
            $chart['incoming'][] = round($row['incoming'], 2);
            $chart['outgoing'][] = round($row['outgoing'], 2);
        }

        $this->set(compact('chart', 'date'));
    }
}
?>
