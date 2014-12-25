<?php
class AnalyzeComponent extends Object {
    function AnalyzeComponent() {
        $this->statistic = array('request_total'=>0);
    }

    function process($ip, $files, $statisticFile) {
        $this->log("running analytics $ip", 'debug');
        foreach($files as $file) {
            $this->log("analytics for $file", 'debug');
            $this->statistic[basename($file)] = array(
                'in'=>array(), 'out'=>array(), 
                'icmp'=>array(), 'tcp'=>array(), 'udp'=>array(), 
                'ports'=>array(), 'total'=>0);

            $this->calculate($file, $ip);
            $this->persistDay(basename($file), $statisticFile);
            $this->statistic[basename($file)] = null;
        }

        $this->writeRequestTotal($statisticFile);
    }

    function calculate($file, $ip) {
        $fp = fopen($file, 'r');
        if (!$fp) return;
        while(!feof($fp)) {
            $row = $this->parseLine(fgets($fp));
            if ($row == null) continue;

            $otherIp = "";
            if ($row['src'] == $ip) {
                $dstIp = ip2long($row['dst']);
                $this->initKey($dstIp, $this->statistic[basename($file)]['out']);
                $this->statistic[basename($file)]['out'][$dstIp] += $row['bytes'];

                $this->initKey($row['dst_port'], $this->statistic[basename($file)]['ports']);
                $this->statistic[basename($file)]['ports'][$row['dst_port']] += $row['bytes'];

                $otherIp = $dstIp;
            } else if ($row['dst'] == $ip) {
                $srcIp = ip2long($row['src']);

                $this->initKey($srcIp, $this->statistic[basename($file)]['in']);
                $this->statistic[basename($file)]['in'][$srcIp] += $row['bytes'];

                $this->initKey($row['src_port'], $this->statistic[basename($file)]['ports']);
                $this->statistic[basename($file)]['ports'][$row['src_port']] += $row['bytes'];

                $otherIp = $srcIp;
            }

            if ($row['proto'] == 1) {
                $this->initKey($otherIp, $this->statistic[basename($file)]['icmp']);
                $this->statistic[basename($file)]['icmp'][$otherIp] += $row['bytes'];
            } else if ($row['proto'] == 6) {
                $this->initKey($otherIp, $this->statistic[basename($file)]['tcp']);
                $this->statistic[basename($file)]['tcp'][$otherIp] += $row['bytes'];
            } else if ($row['proto'] == 17) {
                $this->initKey($otherIp, $this->statistic[basename($file)]['udp']);
                $this->statistic[basename($file)]['udp'][$otherIp] += $row['bytes'];
            }

            $this->statistic[basename($file)]['total'] += $row['bytes'];
        }
        fclose($fp);

        $this->statistic['request_total'] += $this->statistic[basename($file)]['total'];

        arsort($this->statistic[basename($file)]['in']);
        arsort($this->statistic[basename($file)]['out']);
        arsort($this->statistic[basename($file)]['icmp']);
        arsort($this->statistic[basename($file)]['tcp']);
        arsort($this->statistic[basename($file)]['udp']);
        arsort($this->statistic[basename($file)]['ports']);

        $this->log('calculating statistic complete', 'debug');
    }

    function persistDay($day, $file) {
        $fp = fopen($file, 'a+');
        fprintf($fp, "===== %s =====================\n", $day);
        fwrite($fp, $this->getStatisticDescription($this->statistic[$day]));
        fwrite($fp, "\n\n");
        fclose($fp);
    }

    function writeRequestTotal($file) {
        $fp = fopen($file, 'a+');
        fprintf($fp, "Request Total: %.3fM\n", $this->statistic['request_total']/MEGABYTE);
        fclose($fp);
    }

    function getStatisticDescription($value) {
        $description = "";
        foreach($value as $serie=>$values) {
            $index = 0;

            if($serie == 'total') {
                $description .= sprintf("Total: %.3fM\n", $values/MEGABYTE);
            } else {
                $description .= "=== $serie ===\n";
                foreach($values as $key=>$bytes) {
                    if ($serie != 'ports') $key = long2ip($key);
                    $description .= sprintf("%-20s %.3fM\n", $key, $bytes/MEGABYTE);
                    if (++$index > 5) break;
                }
            }
            $description .= "\n";
        }
        return $description;
    }

    private function parseLine($line) {
        $line = str_replace("\t", " ", $line);
        $cols = explode(" ", $line);
        $row = array();
        foreach($cols as $elem) if (!empty($elem)) $row[] = $elem;
        if (count($row) < 9) return null;
        return array(
            'date'=>$row[0],
            'time'=>$row[1],
            'src'=>$row[2],
            'dst'=>$row[3],
            'src_port'=>$row[6],
            'dst_port'=>$row[7],
            'bytes'=>$row[5],
            'proto'=>$row[8]
        );
    }

    private function initKey($ip, &$arr) {
        if (!isset($arr[$ip])) $arr[$ip] = 0;
    }
}
?>
