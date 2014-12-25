<div class="clientTypes form">
<?php echo $this->Form->create('ClientType');?>
	<fieldset>
 		<legend><?php __('Add Client Type'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Client Types', true), array('action' => 'index'));?></li>
	</ul>
</div>
