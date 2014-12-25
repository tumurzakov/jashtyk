<?php
class PaymentCategory extends AppModel {
    var $displayField = 'description';

    function get($name) {
        $category = $this->findByName($name);
        if (!empty($category)) {
            return $category['PaymentCategory']['id'];
        }
        return 0;
    }
}
?>
