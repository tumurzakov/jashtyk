<?php
class Config extends AppModel {
    var $useTable = 'config';

    function get($name, $default = null) {
        $config = $this->findByName($name);
        if ($config) {
            return $config['Config']['value'];
        }
        return $default;
    }
}
?>
