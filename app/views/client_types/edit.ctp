<div class="clientTypes form">
<?php echo $this->Form->create('ClientType');?>
	<fieldset>
 		<legend><?php __('Edit Client Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ClientType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ClientType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Client Types', true), array('action' => 'index'));?></li>
	</ul>
</div>
