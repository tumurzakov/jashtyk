<div class="ips form">
<?php echo $this->Form->create('Ip', array('url'=>array('action'=>'add', $client['Client']['id'])));?>
	<fieldset>
 		<legend><?php printf(__('Add IP subnet to room %s', true), $client['Client']['name']); ?></legend>
	<?php
		echo $this->Form->input('start_ip', array('minWidth'=>15));
		echo $this->Form->input('count', array('default'=>1, 'label'=>__('Count (Could be in range of 1 to 254)', true)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('View Client', true), array('controller'=>'clients', 'action' => 'view', $client['Client']['id']));?></li>
		<li><?php echo $this->Html->link(__('List Clients', true), array('controller' => 'clients', 'action' => 'index')); ?> </li>
	</ul>
</div>
