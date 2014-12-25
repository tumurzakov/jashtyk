<div class="payments index">
	<h2><?php __('Payments');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('payment_category_id');?></th>
			<th><?php echo $this->Paginator->sort('room_session_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('amount');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
		<td><?php echo $payment['PaymentCategory']['description']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($payment['RoomSession']['name'], array('controller' => 'room_sessions', 'action' => 'view', $payment['RoomSession']['id'])); ?>
		</td>
		<td><?php echo $payment['Payment']['created']; ?>&nbsp;</td>
		<td><?php echo $payment['Payment']['amount']; ?>&nbsp;</td>
		<td><?php echo $payment['Payment']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $payment['Payment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $payment['Payment']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payment['Payment']['id'])); ?>
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
    <div class='payments-filter'>
        <?php
        echo $form->create('Payment', array('action'=>"index"));
        echo $form->input('filter', array('maxLength'=>50));
        echo $form->input('date', array('label'=>'', 'type'=>'date', 'dateFormat'=>'DMY', 'minYear'=>'2010', 'maxYear'=>'2020')); 
        echo $form->end(__('Filter', true));
        ?>
    </div>

    <ul>
    </ul>
</div>
