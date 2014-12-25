<?php
class IpcadShell extends Shell {
    var $uses = array('Config');

    var $collectors = array();

    function main() {
        App::import('Component','ArchiveCollector');
        $this->collectors[] = new ArchiveCollectorComponent(null);

        App::import('Component','TrafficCollector');
        $this->collectors[] = new TrafficCollectorComponent(null);

        App::import('Component','ChannelCollector');
        $this->collectors[] = new ChannelCollectorComponent(null);

        if (count($this->args) > 0) {
            if (in_array('update', $this->args)) {
                if (isset($this->args[1])) {
                    $this->update($this->args[1]);
                } else {
                    $this->out("You haven't specified an ipcad data file");
                }
            } else {
                $this->help();
            }
        }
    }

    function help() {
        $this->out('Ipcad data archiving tool: cake ipcad <param>');
        $this->out('  update <file> - update statistic with new data');
        $this->hr();
    }

    private function update($file) {
        $this->collect($file);
        $this->persist();
        $this->out("Statistic successfully updated...");
    }

    private function persist() {
        $this->out("Writing statistic...");
        foreach($this->collectors as &$collector) {
            $collector->persist();
        }
    }

    private function collect($file) {
        $this->out("Getting statistic by IP adress...");
        if($fp = fopen($file, 'r')) {
            $time = strftime("%Y-%m-%d %H:%M:%S");
            $ipcadLineDetailPattern = '/' .
                        '(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s+'. #src ip
                        '(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s+'. #dst ip
                        '(\d+)\s+'. #packet count
                        '(\d+)\s+'. #bytes count
                        '(\d+)\s+'. #src port
                        '(\d+)\s+'. #dst port
                        '(\d+)\s+'. #protocol
                        '.*/';

            while(!feof($fp)) {
                $line = fgets($fp);
                if (preg_match($ipcadLineDetailPattern, $line, $matches)) {
                    foreach($this->collectors as &$collector) {
                        $collector->add($matches, array('time'=>$time));
                    }
                }
            }
            fclose($fp);
        } else {
            $this->out("File not found: $file");
        }
    }
}
?>
