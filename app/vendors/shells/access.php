<?php
App::import('Component', 'Access');

class AccessShell extends Shell {
    var $uses = array('RoomSession', 'Client', 'Tariff', 'Payment'); 
    function main() {
        $access = new AccessComponent(null);

        $roomSessions = $this->RoomSession->find('all', array('conditions'=>array(
            'RoomSessionStatus.name'=>'Started')));
        foreach($roomSessions as $roomSession) {
            $usage = $this->Tariff->getUsage($roomSession);
            $status = $this->Client->getStatus($roomSession['RoomSession']['client_id']);
            $balance = $roomSession['RoomSession']['balance']-$usage['usage'];
            $limit = $roomSession['RoomSession']['limit'];
            if ($status == 'on' && $balance<$limit) {
                $this->Payment->event($roomSession['RoomSession']['id'], sprintf(
                    __('Blocked by the monetary debt %.2f < %.2f', true), $balance, $limit));

                $this->Client->deny($roomSession['RoomSession']['client_id']);
            }

            if ($status == 'on' && $balance>=$limit) {
                $this->Client->allow($roomSession['RoomSession']['client_id']);
            }
        }
    }
}
?>
