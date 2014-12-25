<table><tr><td class="traffic-detail-ip-list">
    <div class="traffic-menu">
        <p><?php echo $html->link(__('Chart', true), array('action'=>'client_chart', $clientId));?></p>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td <?php echo $selectedIp == 'all' ? 'class="traffic-selected-ip"' : ''?>>
                <?php echo $html->link(__('All', true), array('action'=>'client_month', 
                $client['Client']['id'], 'all', $month)); ?>
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
            <td <?php echo $selectedIp == $ip['ip'] ? 'class="traffic-selected-ip"' : ''?>>
                <?php echo $html->link($ip['ip'], array('action'=>'client_month', $client['Client']['id'], $ip['ip'], $month));?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</td><td>
	<table cellpadding="0" cellspacing="0"><tr><td>
        <h2><?php echo sprintf(__('Detail traffic by day for %s', true), $client['Client']['name']); ?></h2>
    </td><td>
        <div class="traffic-detail-report">
            <?php
            echo $form->create(null, array('action'=>"client_month"));
            echo $form->input('clientId', array('type'=>'hidden', 'value'=>$clientId));
            echo $form->input('ip', array('type'=>'hidden', 'value'=>$selectedIp));
            echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'MY', 
                'minYear'=>'2010', 'maxYear'=>'2020', 'selected'=>$month)); 
            echo $form->end(__('Report', true));
            ?>
        </div>
    </td></tr></table>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Date'); ?></th>
			<th><?php __('Global In'); ?></th>
			<th><?php __('Global Out'); ?></th>
			<th><?php __('Peering In'); ?></th>
			<th><?php __('Peering Out'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($report as $day):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
        <td class='traffic-client-day'>
            <?php echo $html->link($day['date'], array('action'=>'client_day', $clientId, 'all', $day['date'])); ?></td>
        <td><?php echo $traffic->format($day['global_in_sum']); ?></td>
        <td><?php echo $traffic->format($day['global_out_sum']); ?></td>
        <td><?php echo $traffic->format($day['peering_in_sum']); ?></td>
        <td><?php echo $traffic->format($day['peering_out_sum']); ?></td>
	</tr>
    <?php endforeach; ?>
    </table>
</td></tr></table>
