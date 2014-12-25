<?php
class SystemComponent extends Object {
    function run($cmd) {
        $this->log("running command $cmd", "debug");

        $spec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "r")
        );

        $process = proc_open($cmd, $spec, $pipes);
        if (is_resource($process)) {
            $result = stream_get_contents($pipes[1]);
            $result .= stream_get_contents($pipes[2]);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            return $result;
        }
        throw new Exception("Error running $cmd");
    }
}
?>
