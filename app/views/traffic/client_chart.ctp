<div class="traffic-menu">
    <p><?php echo $html->link(__('Table', true), array('action'=>'client_month', $client['Client']['id'], 'all'));?></p>
</div>

<table><tr><td>
    <h2><?php echo $client['Client']['name']; ?></h2>

    <table class="traffic-detail-ip-list" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <a class='traffic-selected-ip' href='javascript: void(0);' data-name="all"><?php __('All'); ?></a>
            </td>
        </tr>
        <?php
        $i = 0;
        foreach ($client['Ip'] as $ip):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>
            <td>
                <a href='javascript: void(0);' data-name="<?php echo $ip['ip']; ?>"><?php echo $ip['ip']; ?></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="traffic-detail-report">
        <?php
        echo $form->create(null, array('action'=>"client_chart/1"));
        echo $form->input('ip', array('type'=>'hidden', 'value'=>$selectedIp));
        echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'MY', 
            'minYear'=>'2010', 'maxYear'=>'2020', 'selected'=>$month)); 
        echo $form->end(__('Report', true));
        ?>
    </div>

    <table class='traffic-detail-day-list' cellpadding="0" cellspacing="0">
        <?php
        $i = 0;
        foreach ($days as $day):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>
            <td>
                <a href='javascript:void(0);' class='<?php echo $day == strftime("%F") ? "traffic-selected-ip" : "";?>'
                    data-name="<?php echo $day; ?>"><?php echo $day; ?></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</td><td>
    <div id="client-chart-panel">
        <img id='client-chart' src='../client_chart_data/<?php echo $client['Client']['id']; ?>.png'>
    </div>
</td></tr></table>

<script language='javascript'>
    var selected_day = '<?php echo count($days) > 0 ? $days[0] : ""; ?>'; 
    var selected_ip = 'all';

    function select_day() {
        $('.traffic-detail-day-list a').removeClass('traffic-selected-ip');
        $(this).addClass('traffic-selected-ip');
        selected_day = $(this).attr("data-name");
        load();
    }

    function select_ip() {
        $('.traffic-detail-ip-list a').removeClass('traffic-selected-ip');
        $(this).addClass('traffic-selected-ip');
        selected_ip = $(this).attr("data-name");
        load();
    }

    function load() {
        if (selected_day != "" && selected_ip != "") {
            var now = new Date();
            var nocache = now.getTime();

            var chart = $('#client-chart');
            chart.hide();
            chart.attr('src', '../client_chart_data/<?php echo $client['Client']['id']; ?>/' + 
                selected_ip + '/' + selected_day.toLowerCase() + '.png?cache=' + nocache);
        }
    }

    $(document).ready(function() {
        $('#client-chart').load(function() {
            $(this).show();
        });

        $('.traffic-detail-day-list a').click(select_day);
        $('.traffic-detail-ip-list a').click(select_ip);
    });
</script>
