<div class="networks form">
<?php echo $this->Form->create('Network');?>
	<fieldset>
 		<legend><?php __('Add Network'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Networks', true), array('action' => 'index'));?></li>
	</ul>
</div>
