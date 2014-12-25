<div class="ips form">
<?php echo $this->Form->create('Ip');?>
	<fieldset>
 		<legend>
            <?php printf(__('Edit ip of room %s', true ), $ip['Client']['name']); ?>
        </legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ip', array('minWidth'=>15));

		echo $this->Form->input('mac', array(
            'after'=>__("Current", true) . ": " . 
                (!empty($mac) ? $mac : __('not found', true))
                ));

        echo $this->Form->input('description', array('rows'=>3));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('List Ips', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Room', true), array('controller' => 'clients', 'action' => 'view', $ip['Client']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Ip.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Ip.id'))); ?></li>
	</ul>
</div>
