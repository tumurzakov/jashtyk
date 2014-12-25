<div class="roomSessions form">
<?php echo $this->Form->create('RoomSession', array('action'=>'changeTraffic'));?>
	<fieldset>
 		<legend><?php __('Change Traffic'); ?></legend>

        <table>
            <?php foreach(array('global_in', 'global_out', 'peering_in', 'peering_out') as $dir): ?>
            <tr>
                <td><?php echo $this->Form->input($dir, array('value'=>'',
                    'after'=>sprintf('%.2f Mb', $roomSession['RoomSession'][$dir]/MEGABYTE))); ?></td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <td><?php echo $this->Form->input('description', array('rows'=>5));?></td>
            </tr>

            <tr>
                <td>
                    <?php echo $this->Form->end(__('Submit', true));?>
                </td>
            </tr>

        </table>
	</fieldset>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('View', true), array('action' => 'view', $roomSession['RoomSession']['id']));?></li>
		<li><?php echo $this->Html->link(__('List Room Sessions', true), array('action' => 'index'));?></li>
	</ul>
</div>
