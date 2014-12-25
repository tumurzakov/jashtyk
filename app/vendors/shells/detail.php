<?php
App::import("Component", "Detail");
class DetailShell extends Shell {
    function main() {
        $this->Detail = new DetailComponent();
        $this->Detail->process();
    }
}
?>
