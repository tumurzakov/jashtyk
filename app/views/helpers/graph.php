<?php
require_once("vendors/pChart2.1.3/class/pDraw.class.php");
require_once("vendors/pChart2.1.3/class/pImage.class.php");
require_once("vendors/pChart2.1.3/class/pData.class.php");
require_once("vendors/pChart2.1.3/class/pCache.class.php");

class GraphHelper extends AppHelper {
    var $cacheFolder = "../tmp/pChart";

    function network($data, $title="") {

        $myData = new pData();

        $myData->addPoints($data['incoming'],"incoming");
        $myData->setPalette("incoming", array("R"=>255,"G"=>0,"B"=>0,"Alpha"=>60));

        $myData->addPoints($data['outgoing'],"outgoing");
        $myData->setPalette("incoming", array("R"=>0,"G"=>255,"B"=>0,"Alpha"=>60));

        $myData->addPoints($data['time'], "time");
        $myData->setAbscissa("time");

        $myData->setAxisName(0, __("Bandwidth Mbit/s", true));

        $myCache = $this->getCache();
        $cacheImage = $this->cacheFolder."/cache.png";
        $chartHash = md5($title).$myCache->getHash($myData);
        if ($myCache->isInCache($chartHash)) {
            $myCache->saveFromCache($chartHash,$cacheImage);
        } else {
            $myPicture = new pImage(700,500,$myData);

            $myPicture->setFontProperties(array("FontName"=>"../webroot/files/verdana.ttf","FontSize"=>7));
            $myPicture->drawFilledRectangle(60,30,650,440,array("R"=>0,"G"=>0,"B"=>255,"Alpha"=>15));
            $myPicture->setGraphArea(60,30,650,440);

            $scaleOptions = array("Mode"=>SCALE_MODE_START0);
            $skip=ceil(count($data["time"])/12) - 1;
            if ($skip > 1) $scaleOptions["LabelSkip"] = $skip;

            $myPicture->drawScale($scaleOptions);

            $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
            $myPicture->drawLineChart(array("DisplayValues"=>FALSE,"DisplayColor"=>DISPLAY_AUTO));

            $myPicture->drawText(20,20, $title, array("R"=>0,"G"=>0,"B"=>0,"FontSize"=>8));
            $myCache->writeToCache($chartHash,$myPicture);

            $myPicture->Render($cacheImage);
        }

        print file_get_contents($cacheImage);
    }

    function smooth($data, $k=1) {
        if ($k == 1) return $data;
        $count = count($data);
        $result = array();
        if ($count > $k) for($i=$k-1; $i<count($data); $i++) {
            $sum = 0;
            for($j=0; $j<$k; $j++) {
                $sum += $data[$i - $j];
            }
            $result[$i] = $sum / $k;
        }
        return $result;
    }

    private function getCache() {
        if (!is_dir($this->cacheFolder)) mkdir($this->cacheFolder);
        return new pCache(array("CacheFolder"=>$this->cacheFolder));
    }
}
