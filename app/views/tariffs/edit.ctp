<div class="tariffs form">
<?php echo $this->Form->create('Tariff');?>
	<fieldset>
 		<legend><?php __('Edit Tariff'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description', array('rows' => '5'));
		echo $this->Form->input('global_price', array('after'=>$currency));
		echo $this->Form->input('peering_price', array('after'=>$currency));
		echo $this->Form->input('starting_balance', array('after'=>$currency));
		echo $this->Form->input('default_limit', array('after'=>$currency));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('New Tariff', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Tariff.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Tariff.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tariffs', true), array('action' => 'index'));?></li>
	</ul>
</div>
