<?php
App::import('Component', 'System');
class AccessComponent extends Object {
    function __construct($controller = null) {
        $this->System = new SystemComponent(null);
        $this->Config = ClassRegistry::init('Config');
    }

    function allow($ip) {
        $this->log("allow access for $ip", "access");
        $this->System->run(sprintf($this->Config->get('allow_rule'), $ip));
    }

    function deny($ip) {
        $this->log("deny access for $ip", "access");
        $this->System->run(sprintf($this->Config->get('deny_rule'), $ip));
    }

    function check($ip) {
        $status = $this->status();
        return isset($status["$ip/32"]);
    }

    function status() {
        $list = $this->System->run($this->Config->get('firewall_status'));
        $lines = explode("\n", $list);
        $status = array();
        foreach($lines as $line) {
            if (preg_match("/(.*)\/(\d+)/", $line, $matches)) {
                $status[trim($matches[0])] = array('network'=>$matches[1], 'mask'=>$matches[2]);
            }
        }
        return $status;
    }

    function macs() {
        $list = $this->System->run($this->Config->get('mac_bindings'));
        $lines = explode("\n", $list);
        $status = array();
        foreach($lines as $line) {
            if (preg_match("/".
                    "^([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}) .*".
                    "([0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2}:[0-9abcdef]{2})$".
                    "/i", trim($line), $matches)) {
                $status[$matches[1]] = array( 
                    'mac'=>$matches[2], 
                    'permanent'=>strpos('permanent', $line) > 0
                    );
            }
        }
        return $status;

    }
}
?>
