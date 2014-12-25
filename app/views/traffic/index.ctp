<?php 
$this->Html->script("locale.js", array('inline'=>false)); 
$this->Html->script("ru.js", array('inline'=>false)); 

$this->Html->css("/js/jqPlot/jquery.jqplot.min.css", null, array('inline'=>false)); 
$this->Html->script("jqPlot/jquery.jqplot.js", array('inline'=>false)); 
    $this->Html->script("jqPlot/plugins/jqplot.highlighter.min.js", array('inline'=>false));
$this->Html->script("jqPlot/plugins/jqplot.pieRenderer.min.js", array('inline'=>false));

if (count($report) > 0 ) {
    $this->Html->script("traffic_pie_chart.js", array('inline'=>false)); 
}
?>
<div class="actions traffic-pie-chart">
    <div>
        <p><?php echo __('From') . ": $begin"; ?></p>
        <p><?php echo __('To') . ": $end"; ?></p>
    </div>
    <div>
        <?php
        echo $form->create(null, array('action'=>"index"));
        echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'MY', 'minYear'=>'2010', 'maxYear'=>'2020')); 
        echo $form->end(__('Report', true));
        ?>
    </div>

    <div id="traffic-pie-chart" ></div>
    <div id="traffic-pie-chart-highlight"></div>

</div>

<div class="traffic index">
	<h2><?php __('Clients traffic');?></h2>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Client'); ?></th>
			<th><?php __('Client Type'); ?></th>
			<th><?php __('Global In (Mb)'); ?></th>
			<th><?php __('Global Out (Mb)'); ?></th>
			<th><?php __('Peering In (Mb)'); ?></th>
			<th><?php __('Peering Out (Mb)'); ?></th>
			<th><?php __('Percent'); ?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($report as $client):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = 'altrow';
		}

	?>
	<tr class="traffic-table <?php echo $class;?> <?php echo "{$client['type']}-client"; ?>">

        <td class="traffic-client"><?php echo $client['client_id']>0 ? $html->link($client['client_name'], 
            array('action'=>'client_month', $client['client_id'], 'all', $begin)) : 
            "<b>{$client['client_name']}</b>"; ?></td>
        <td><?php echo $client['type_name'];?></td>
        <td><?php echo $traffic->format($client['global_in_sum']); ?></td>
        <td><?php echo $traffic->format($client['global_out_sum']); ?></td>
        <td><?php echo $traffic->format($client['peering_in_sum']); ?></td>
        <td><?php echo $traffic->format($client['peering_out_sum']); ?></td>
        <td class="traffic-percent"><?php echo sprintf("%.2f", $client['percent']);?></td>
	</tr>
    <?php endforeach; ?>
    </table>
</div>
