<?php
class TrafficHelper extends AppHelper {
    function format($traffic) {
        return $this->output(sprintf('%.2f', $traffic/MEGABYTE));
    }
}
?>
