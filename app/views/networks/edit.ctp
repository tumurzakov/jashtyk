<div class="networks form">
<?php echo $this->Form->create('Network');?>
	<fieldset>
 		<legend><?php __('Edit Network'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('network', array('maxLength'=>15));
		echo $this->Form->input('mask', array('maxLength'=>15));
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Network.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Network.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Networks', true), array('action' => 'index'));?></li>
	</ul>
</div>
