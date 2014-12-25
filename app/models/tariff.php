<?php
class Tariff extends AppModel {
	var $name = 'Tariff';
	var $displayField = 'name';

    function getUsage($session) {
        $global = round(($session['RoomSession']['global_in'] + $session['RoomSession']['global_out'])/MEGABYTE, 2);
        $globalPrice = $session['Tariff']['global_price'];
        $globalUsage = $global * $globalPrice;

        $peering = round(($session['RoomSession']['peering_in'] + $session['RoomSession']['peering_out'])/MEGABYTE, 2);
        $peeringPrice = $session['Tariff']['peering_price'];
        $peeringUsage = $peering * $peeringPrice;

        $usage = $globalUsage + $peeringUsage;

        return compact('global', 'globalUsage', 'globalPrice', 'peering', 'peeringUsage', 'peeringPrice', 'usage');
    }
}
?>
