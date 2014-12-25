<div class="peerings index">
	<h2><?php __('Peerings');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('network');?></th>
			<th><?php echo $this->Paginator->sort('mask');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($peerings as $peering):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $peering['Peering']['id']; ?>&nbsp;</td>
		<td><?php echo $peering['Peering']['network']; ?>&nbsp;</td>
		<td><?php echo $peering['Peering']['mask']; ?>&nbsp;</td>
		<td><?php echo $peering['Peering']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $peering['Peering']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $peering['Peering']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $peering['Peering']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $peering['Peering']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Peering', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Update', true), array('action' => 'update')); ?></li>
	</ul>
</div>
