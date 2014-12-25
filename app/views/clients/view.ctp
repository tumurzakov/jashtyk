<div class="clients view">
<h2><?php  __('Client');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $client['Client']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $client['Client']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $client['Client']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $client['ClientType']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Chart', true), array('controller'=>'traffic', 'action' => 'client_chart', $client['Client']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Client', true), array('action' => 'edit', $client['Client']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Client', true), array('action' => 'delete', $client['Client']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Turn on', true), array('action' => 'access', $client['Client']['id'], 'allow')); ?> </li>
		<li><?php echo $this->Html->link(__('Turn off', true), array('action' => 'access', $client['Client']['id'], 'deny')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Ips');?></h3>
	<?php if (!empty($client['Ip'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Ip'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
		<th><?php __('Ip'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	<?php
		$i = 0;
		foreach ($client['Ip'] as $ip):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
                echo "</tr><tr $class>";
			}
		?>
			<td><div class='<?php echo isset($status["{$ip['ip']}/32"])?"access-on":"access-off"; ?>'><?php echo $ip['ip'];?></div></td>
			<td class="ip-actions actions">
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ips', 'action' => 'edit', $ip['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ips', 'action' => 'delete', $ip['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ip['id'])); ?>
                <?php echo $this->Html->link(__('Turn on', true), array('controller'=>'ips', 'action' => 'access', $ip['id'], 'allow')); ?> 
                <?php echo $this->Html->link(__('Turn off', true), array('controller'=>'ips', 'action' => 'access', $ip['id'], 'deny')); ?>

			</td>
	<?php endforeach; ?>
	</tr>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ip', true), array('controller' => 'ips', 'action' => 'add', $client['Client']['id']));?> </li>
		</ul>
	</div>
</div>
