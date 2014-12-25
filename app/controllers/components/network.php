<?php
App::import('Model', 'Network');

class NetworkComponent extends Object {
    function NetworkComponent() {
        $this->Peering = ClassRegistry::init('Peering');
        $this->Network = ClassRegistry::init('Network');

        $this->billingNetworks = $this->Network->find('all');
        $this->peeringNetworks = $this->Peering->find('all');
    }

    static function ip2long($ip) {
        return NetworkComponent::int2uint(ip2long($ip));
    }

    static function int2uint($int) {
        return sprintf("%u", $int);
    }

    static function uint2int($uint) {
        if (gettype($uint) == "string") {
            if ($uint == "2147483647") return $uint;
            if ($uint < PHP_INT_MAX) return $uint;
            return intval(doubleval($uint) & PHP_INT_MAX) | (PHP_INT_MAX + 1);
        }
        return $uint;
    }

    function isIpInNetwork($ip, $network, $mask) {
        return ($network & $mask) == ($ip & $mask);
    }

    function isBillingIp($ip) {
        foreach($this->billingNetworks as $network) {
            if ($this->isIpInNetwork($ip, $network['Network']['network_long'], $network['Network']['mask_long'])) {
                return true;
            }
        }
        return false;
    }

    function isPeeringIp($ip) {
        foreach($this->peeringNetworks as $network) {
            if ($this->isIpInNetwork($ip, $network['Peering']['network_long'], $network['Peering']['mask_long'])) {
                return true;
            }
        }
        return false;
    }

    function parseCidr($cidr) {
        $result = array();
        if (preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\/([0-9]{2})/', $cidr, $matches)) {
            $result['network'] = $matches[1];
            $result['network_long'] = ip2long($matches[1]);
            $result['network_uint'] = $this->ip2long($matches[1]);

            $bits = intval($matches[2]);
            $mask = 1;
            for($i=0; $i<32; $i++) {
                $mask<<=1;
                if ($i<$bits) $mask+=1;
            }

            $result['mask'] = long2ip($mask);
            $result['mask_uint'] = $this->int2uint($mask);
            $result['mask_long'] = $mask;
        }

        return $result;
    }
}
?>
