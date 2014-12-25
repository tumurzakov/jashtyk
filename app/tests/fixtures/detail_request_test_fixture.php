<?php
class DetailRequestTestFixture extends CakeTestFixture {
    var $name = 'DetailRequest';
    var $import = 'DetailRequest';
    var $records = array(
        array('id'=>1, 
            'ip'=>'212.112.96.1', 
            'from'=>'2010-01-01', 
            'to'=>'2010-02-02', 
            'status'=>'accepted', 
            'description'=>null, 
            'created'=>'2010-01-01 00:00:00', 
            'started'=>null, 
            'completed'=>null, 
            'file'=>null),

        array('id'=>2, 
            'ip'=>'212.112.96.2', 
            'from'=>'2010-01-01', 
            'to'=>'2010-02-02', 
            'status'=>'processing', 
            'description'=>null, 
            'created'=>'2010-01-01 00:00:00', 
            'started'=>'2010-01-01 01:00:00', 
            'completed'=>null, 
            'file'=>null),

        array('id'=>3, 
            'ip'=>'212.112.96.1', 
            'from'=>'2010-01-01', 
            'to'=>'2010-02-02', 
            'status'=>'accepted', 
            'description'=>null, 
            'created'=>'2010-01-02 00:00:00', 
            'started'=>null, 
            'completed'=>null, 
            'file'=>null)
    );
}
?>
