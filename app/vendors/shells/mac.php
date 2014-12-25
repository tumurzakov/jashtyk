<?php
App::import('Component', 'System');

class MacShell extends Shell {
    var $uses = array('Ip', 'Config'); 
    function main() {
        $system = new SystemComponent(null);
        $ips = $this->Ip->find('all');
        foreach($ips as $ip) {
            if (preg_match('/[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}/i', 
                $ip['Ip']['mac'])) {
                $command = $this->Config->get('mac_bind');
            } else {
                $command = $this->Config->get('mac_unbind');
            }

            $command = str_replace("{ip}", $ip['Ip']['ip'], $command);
            $command = str_replace("{mac}", $ip['Ip']['mac'], $command);

            $system->run($command);
        }
    }
}
?>
