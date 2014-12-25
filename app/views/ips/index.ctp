<div class="ips index">
	<h2><?php __('Ips');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('client_id');?></th>
			<th><?php echo $this->Paginator->sort('ip');?></th>
			<th><?php echo $this->Paginator->sort('mac');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($ips as $ip):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $ip['Ip']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ip['Client']['name'], array('controller' => 'clients', 'action' => 'view', $ip['Client']['id'])); ?>
		</td>
		<td><?php echo $ip['Ip']['ip']; ?>&nbsp;</td>
		<td>
            <?php $system_mac = isset($macs[$ip['Ip']['ip']]) ? $macs[$ip['Ip']['ip']]['mac'] : ""; ?>
            <div class='<?php 
                echo !empty($system_mac) && $system_mac == $ip['Ip']['mac'] ? "access-on" : "access-off"?>'>
                    <?php echo empty($ip['Ip']['mac']) && !empty($system_mac) ? $system_mac : $ip['Ip']['mac'];?>
            </div>
        </td>
		<td><?php echo $ip['Ip']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $ip['Ip']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $ip['Ip']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ip['Ip']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Clients', true), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client', true), array('controller' => 'clients', 'action' => 'add')); ?> </li>
	</ul>
</div>
