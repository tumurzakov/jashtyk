<div class="traffic view">
<h2><?php  __('Statistic');?></h2>

    <?php
    echo $form->create(null, array('action'=>"statistic"));
    echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'MY', 'minYear'=>'2010', 'maxYear'=>'2020')); 
    echo $form->end(__('Report', true));
    ?>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $client['Client']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global In'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $traffic->format($clientTraffic['global_in_sum']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global Out'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $traffic->format($clientTraffic['global_out_sum']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Peering In'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $traffic->format($clientTraffic['peering_in_sum']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Peering Out'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $traffic->format($clientTraffic['peering_out_sum']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price per megabyte'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf("%.2f %s", $finance['price_per_megabyte'], $finance['currency']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf("%.2f %s", $clientTraffic['amount'], $finance['currency']); ?>
			&nbsp;
		</dd>
	</dl>
    <div class="traffic-statistic-detail">
        <?php echo $html->link(__('Details', true), array('action'=>'client_month', $client['Client']['id'], 'all', $begin)); ?>
    </div>
</div>
