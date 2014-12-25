<div class="tariffs index">
	<h2><?php __('Tariffs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('global_price');?></th>
			<th><?php echo $this->Paginator->sort('peering_price');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($tariffs as $tariff):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $tariff['Tariff']['id']; ?>&nbsp;</td>
		<td><?php echo $tariff['Tariff']['name']; ?>&nbsp;</td>
		<td><?php echo $tariff['Tariff']['description']; ?>&nbsp;</td>
		<td><?php echo $tariff['Tariff']['global_price']; ?>&nbsp;</td>
		<td><?php echo $tariff['Tariff']['peering_price']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $tariff['Tariff']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tariff['Tariff']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $tariff['Tariff']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tariff['Tariff']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Tariff', true), array('action' => 'add')); ?></li>
	</ul>
</div>
