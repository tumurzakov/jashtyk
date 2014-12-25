<?php
class TrafficController extends AppController {
    var $uses = array('TrafficSummary', 'TrafficDetail', 'Config', 'Client');
    var $components = array('Auth', 'Date');
    var $helpers = array('Traffic', 'Graph');

    function index() {
        $begin = !isset($this->data['TrafficSummary']['month']) ? strftime('%Y-%m-01') : 
            sprintf('%s-%s-01', $this->data['TrafficSummary']['month']['year'], $this->data['TrafficSummary']['month']['month']);
        $end = strftime("%F", strtotime('+1 month', strtotime($begin)));

        $report = array();
        $total = array('client_id'=>0, 'type'=>'', 'type_name'=>'',
                'client_name'=>__('Total', true), 
                'global_in_sum'=>0, 'global_out_sum'=>0,
                'peering_in_sum'=>0, 'peering_out_sum'=>0,
                'percent'=>0);

        $global = $this->TrafficSummary->getGlobalTraffic($begin, $end);

        $clients = $this->Client->find('all', array('order'=>'Client.name'));
        foreach($clients as $client) {
            $clientId = $client['Client']['id'];
            $clientsTraffic = $this->TrafficSummary->getTrafficSummary($begin, $end, $clientId);
            $traffic = isset($clientsTraffic[$clientId]) ? $clientsTraffic[$clientId] : 
                array('global_in_sum'=>0,'global_out_sum'=>0,'peering_in_sum'=>0,'peering_out_sum'=>0);

            $percent = 0;
            $clientGlobalTraffic = $traffic['global_in_sum'] + $traffic['global_out_sum'];
            if ($clientGlobalTraffic > 0) {
                $percent = $clientGlobalTraffic / $global * 100;
            }

            $row = array(
                'client_id'=>$clientId,
                'type'=>$client['ClientType']['name'], 
                'type_name'=>$client['ClientType']['description'], 
                'client_name'=>$client['Client']['name'],
                'percent'=>$percent
            );

            $parameters = array('global_in_sum', 'global_out_sum', 'peering_in_sum', 'peering_out_sum');
            foreach($parameters as $parameter) {
                $total[$parameter] += $traffic[$parameter];
                $row[$parameter] = $traffic[$parameter];
            }

            $report[] = $row;
        }

        $report[] = $total;
        $this->set(compact('report', 'begin', 'end'));
    }

    function client_month($clientId=null, $selectedIp=null, $month = null) {
        if (isset($this->data['TrafficSummary'])) {
            $date = sprintf("%d-%02d-01", $this->data['TrafficSummary']['month']['year'], $this->data['TrafficSummary']['month']['month']);
            $this->redirect(array('action'=>'client_month', 
                $this->data['TrafficSummary']['clientId'], 
                $this->data['TrafficSummary']['ip'], $date
                ));
        }

        $month = $month == null ? strftime('%Y-%m-01') : $month;
        $monthEnd = strftime("%F", strtotime('+1 month', strtotime($month)));

        $client = $this->Client->findById($clientId);
        $report = array();
        if ($client) {
            $details = $this->TrafficSummary->getTrafficSummaryByDate($month, $monthEnd, $client['Client']['id'], $selectedIp);
            foreach($details as $day=>$value) {
                $report[] = array(
                    'date'=>$day,
                    'global_in_sum'=>$value['global_in_sum'], 
                    'global_out_sum'=>$value['global_out_sum'], 
                    'peering_in_sum'=>$value['peering_in_sum'], 
                    'peering_out_sum'=>$value['peering_out_sum']
                );
            }
        } else {
			$this->Session->setFlash(__('Invalid client id', true));
        }

        $this->set(compact('client', 'month', 'selectedIp', 'clientId', 'report'));
    }

    function client_day($clientId=null, $selectedIp=null, $day=null) {
        if (isset($this->data['TrafficSummary'])) {
            $this->redirect(array('action'=>'client_day', $this->data['TrafficSummary']['clientId'], $this->data['TrafficSummary']['ip'],
                sprintf('%s-%s-%s', 
                    $this->data['TrafficSummary']['month']['year'], 
                    $this->data['TrafficSummary']['month']['month'],
                    $this->data['TrafficSummary']['month']['day']
                )));
        }

        $dayEnd = strftime("%F", strtotime('+1 day', strtotime($day)));

        $client = $this->Client->findById($clientId);
        if($client) {
            $options = array(
                'limit'=>50,
                'conditions'=>array(
                    'client_id'=>$clientId,
                    'time BETWEEN ? AND ?'=>array(strtotime($day), strtotime($dayEnd))
                ));
            if ($selectedIp != 'all') {
                $options['conditions']['ip']=$selectedIp;
            }
            $this->paginate = $options;
            $this->TrafficDetail->setDate($day);
            $report = $this->paginate($this->TrafficDetail);
        } else {
			$this->Session->setFlash(__('Invalid client id', true));
        }

        $this->set(compact('client', 'day', 'selectedIp', 'clientId', 'report'));
    }

    function client_chart($clientId=null, $selectedIp=null, $month = null) {
        if (isset($this->data['TrafficSummary'])) {
            $month = sprintf("%d-%02d-01", $this->data['TrafficSummary']['month']['year'], 
                $this->data['TrafficSummary']['month']['month']);
        }

        $month = $month == null ? strftime('%Y-%m-01') : $month;
        $monthEnd = strftime("%F", strtotime('+1 month', strtotime($month)));
        $client = $this->Client->findById($clientId);

        $days = array();
        for($i=strtotime($month); $i<strtotime($monthEnd); $i+= 86400) {
            $date = strftime("%F", $i);
            if ($this->TrafficDetail->tableExist($date))
                $days[] = $date;
        }

        $this->set(compact('client', 'days', 'selectedIp', 'clientId', 'month'));
    }

    function client_chart_data($clientId, $ip=null, $date=null) {
        $client = $this->Client->findById($clientId);
        $date = $date != null ? $date : strftime('%F', $this->Date->now());
        
        $data = $this->TrafficDetail->getClientTrafficChartData($clientId, $date, $ip, 300);

        $chart = array( 'time'=>array(), 'incoming'=>array(), 'outgoing'=>array());
        foreach($data as $time => $row) {
            $chart['time'][] = strftime("%H:%M", $time);
            $chart['incoming'][] = round($row['incoming'], 2);
            $chart['outgoing'][] = round($row['outgoing'], 2);
        }

        $this->set(compact('chart', 'date', 'ip', 'client'));
    }
}
?>
