<div class="clients index">
	<h2><?php __('Clients');?></h2>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('client_type_id');?></th>
            <th><?php __('IP'); ?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($clients as $client):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $client['Client']['name']; ?>&nbsp;</td>
		<td><?php echo $client['Client']['description']; ?>&nbsp;</td>
		<td> <?php echo __($client['ClientType']['description']); ?> </td>
        <td>
        <?php foreach($client['Ip'] as $ip):?>
            <div class='<?php echo isset($status["{$ip['ip']}/32"])?"access-on":"access-off"; ?>'><?php echo $ip['ip']; ?></div>
        <?php endforeach;?>
        </td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $client['Client']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $client['Client']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $client['Client']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['id'])); ?>
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
    <div>
        <?php echo $form->create(null, array('action'=>"index")); ?>
        <?php echo __("Filter"); ?>
        <input id="Pattern" type="text" value="<?php echo $pattern; ?>" name="data[pattern]"/>
        <?php echo $form->end(__('Find', true)); ?>
    </div>

	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Client', true), array('action' => 'add')); ?></li>
	</ul>
</div>
