<?php 
if (!isset($_REQUEST['debug_chart'])) {
    Configure::write('debug', 0);
    header("Content-Type: image/png");
    header("Content-Transfer-Encoding: binary");
}
echo $content_for_layout;
?>
