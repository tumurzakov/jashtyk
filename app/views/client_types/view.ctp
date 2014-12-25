<div class="clientTypes view">
<h2><?php  __('Client Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientType['ClientType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientType['ClientType']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientType['ClientType']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Type', true), array('action' => 'edit', $clientType['ClientType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Client Type', true), array('action' => 'delete', $clientType['ClientType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $clientType['ClientType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Type', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
