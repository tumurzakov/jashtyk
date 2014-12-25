<div class="peerings view">
<h2><?php  __('Peering');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peering['Peering']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Network'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peering['Peering']['network']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mask'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peering['Peering']['mask']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $peering['Peering']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Peering', true), array('action' => 'edit', $peering['Peering']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Peering', true), array('action' => 'delete', $peering['Peering']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $peering['Peering']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Peerings', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Peering', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
