<?php
class Group extends AppModel {
    var $name = 'Group';
    var $displayField = 'description';
    var $actsAs = array('Acl' => array('type' => 'requester'));

    function parentNode(){
        return null;
    }
}
?>
