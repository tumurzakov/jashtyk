<div class="networks view">
<h2><?php  __('Network');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $network['Network']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Network'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo long2ip($network['Network']['network']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mask'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo long2ip($network['Network']['mask']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $network['Network']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Network', true), array('action' => 'edit', $network['Network']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Network', true), array('action' => 'delete', $network['Network']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $network['Network']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Networks', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Network', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
