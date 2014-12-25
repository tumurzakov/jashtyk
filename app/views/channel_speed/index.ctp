<h2><?php __("Channel Speed Chart"); ?></h2>
<table>
<tr>
    <td class='channel-speed-date-filter'>
        <?php echo $this->Form->input('date', array(
            'type'=>'date', 'dateFormat'=> 'DMY',
                'minYear'=>2009, 'maxYear'=>date('Y')+1)); ?>
        <br><a href='javascript:void(0)' onclick='day()' ><?php __('Load'); ?></a>
    </td>
    <td><img id='chart' src='<?php echo Router::url('/channel_speed', true);?>/channel_speed_data.png'></td>
</tr>
</table>

<script language='javascript'>
function day() {
    var now = new Date();
    var nocache = now.getTime();

    $('img').hide();
    var dt = $('#dateYear').val() + "-" + $('#dateMonth').val() + "-" + $('#dateDay').val();
    $('#chart').attr('src', '<?php echo Router::url('/channel_speed', true);?>/channel_speed_data/' + 
        dt + '.png?cache=' + nocache);
}

$('img').load(function() {
    $(this).show();
});
</script>
