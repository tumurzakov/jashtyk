<?php
class RoundComponent extends Object {
    function bank($number, $precision = 0) {
        $pow = pow(10, $precision);
        $x = $number * $pow;
        $result = 0;

        $floor = floor($x + 0.5);
        $ceil = ceil($x - 0.5);
        if ($floor == $ceil) $result = $floor;
        $result = (1&$ceil) ? $floor : $ceil;

        return $result / $pow;
    }

    function up($number, $precision = 0) {
        $pow = pow(10, $precision);
        $x = $number * $pow;
        $result = 0;

        $floor = floor($x + 0.5);
        $ceil = ceil($x - 0.5);
        if ($floor == $ceil) $result = $floor;
        $result = $floor;

        return $result / $pow;
    }

    function down($number, $precision = 0) {
        $pow = pow(10, $precision);
        $x = $number * $pow;
        $result = 0;

        $floor = floor($x + 0.5);
        $ceil = ceil($x - 0.5);
        if ($floor == $ceil) $result = $floor;
        $result = $ceil;

        return $result / $pow;
    }

    function ceil($number, $precision = 0) {
        $pow = pow(10, $precision);
        $x = $number * $pow;

        $result = ceil($x);

        return $result / $pow;
    }

    function floor($number, $precision = 0) {
        $pow = pow(10, $precision);
        $x = $number * $pow;

        $result = floor($x);

        return $result / $pow;
    }


}
?>
