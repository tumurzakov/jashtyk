<div class="tariffs view">
<h2><?php  __('Tariff');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['global_price']." $currency"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Peering Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['peering_price']." $currency"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Starting Balance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['starting_balance']." $currency"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Default Limit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tariff['Tariff']['default_limit']." $currency"; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tariff', true), array('action' => 'edit', $tariff['Tariff']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Tariff', true), array('action' => 'delete', $tariff['Tariff']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tariff['Tariff']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tariffs', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tariff', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
