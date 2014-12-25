<div class="roomSessions view">
<h2><?php  __('Room Session');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['Client']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tariff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['Tariff']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Balance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php printf("%.2f %s", $roomSession['RoomSession']['balance'] - $roomSession['usage']['usage'], $currency); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Limit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['limit']." $currency"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Start'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['start']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('End'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['end']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSession']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $roomSession['RoomSessionStatus']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global In'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php printf("%.2f Mb", $roomSession['RoomSession']['global_in']/MEGABYTE); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global Out'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php printf("%.2f Mb", $roomSession['RoomSession']['global_out']/MEGABYTE); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Peering In'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php printf("%.2f Mb", $roomSession['RoomSession']['peering_in']/MEGABYTE); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Peering Out'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php printf("%.2f Mb", $roomSession['RoomSession']['peering_out']/MEGABYTE); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class='room-session-invoice-section'>
<h2><?php  __('Payments');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Id');?></th>
			<th><?php __('Created');?></th>
			<th><?php __('Amount');?></th>
			<th><?php __('Description');?></th>
	</tr>

	<?php
	$i = 0;
	foreach ($payments as $payment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $payment['Payment']['id']; ?>&nbsp;</td>
		<td><?php echo $payment['Payment']['created']; ?>&nbsp;</td>
		<td><?php echo $payment['Payment']['amount'] . " $currency"; ?>&nbsp;</td>
		<td><?php echo $payment['Payment']['description']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
</div>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
        <li>
            <?php 
                if ($roomSession['RoomSession']['client_id']) {
                    if ($roomSession['RoomSessionStatus']['name'] == 'Not started') {
                        echo $this->Html->link(__('Start now', true), array('action' => 'startNow', $roomSession['RoomSession']['id']));
                    } else if (in_array($roomSession['RoomSessionStatus']['name'], array('Started'))) {
                        echo $this->Html->link(__('End now', true), array('action' => 'endNow', $roomSession['RoomSession']['id']));
                    }
                }
            ?>
        </li>
		<li><?php echo $this->Html->link(__('Edit Room Session', true), array('action' => 'edit', $roomSession['RoomSession']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Room Session', true), array('action' => 'delete', $roomSession['RoomSession']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $roomSession['RoomSession']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Session', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Room Sessions', true), array('action' => 'index')); ?> </li>

		<li><?php echo $this->Html->link(__('Change Traffic', true), array('action' => 'changeTraffic', $roomSession['RoomSession']['id'])); ?> </li>

		<li><?php echo $this->Html->link(__('Turn on', true), array('controller'=>'clients', 
            'action' => 'access', $roomSession['RoomSession']['client_id'], 'allow')); ?> </li>

		<li><?php echo $this->Html->link(__('Turn off', true), array('controller'=>'clients', 
            'action' => 'access', $roomSession['RoomSession']['client_id'], 'deny')); ?> </li>

		<li><?php echo $this->Html->link(__('New Payment', true), array('controller'=>'payments', 'action' => 'add', $roomSession['RoomSession']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Invoice', true), array('action' => 'invoice', $roomSession['RoomSession']['id']), array('target' => '_blank')); ?> </li>
	</ul>
</div>
