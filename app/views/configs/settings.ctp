<?php 
foreach ($configs as $config) {
    echo "var {$config['Config']['name']} = '{$config['Config']['value']}';\n";
}
?>
