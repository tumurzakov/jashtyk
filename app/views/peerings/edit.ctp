<div class="peerings form">
<?php echo $this->Form->create('Peering');?>
	<fieldset>
 		<legend><?php __('Edit Peering'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('network');
		echo $this->Form->input('mask');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Peering.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Peering.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Peerings', true), array('action' => 'index'));?></li>
	</ul>
</div>