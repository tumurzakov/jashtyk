<div class="peerings form">
<?php echo $this->Form->create('Peering');?>
	<fieldset>
 		<legend><?php __('Add Peering'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Peerings', true), array('action' => 'index'));?></li>
	</ul>
</div>