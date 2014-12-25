<?php 
$disabled = !in_array($roomSession['RoomSessionStatus']['name'], 
    array('Not started'));
?> 

<div class="roomSessions form">
<?php echo $this->Form->create('RoomSession');?>
	<fieldset>
 		<legend><?php __('Edit Room Session'); ?></legend>

        <table>
            <tr>
                <td colspan='4'><?php echo $this->Form->input('name', 
                    array('disabled'=>$disabled)); ?>
            </tr>
            <tr>
                <td colspan='2'><?php echo $this->Form->input('start', 
                    array('dateFormat'=>'DMY', 'timeFormat'=>24, 
                    'disabled'=>$disabled)); ?></td>
                <td colspan='2'><?php echo $this->Form->input('end', 
                array('dateFormat'=>'DMY', 'timeFormat'=>24)); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('balance', array('disabled'=>true, 'after'=>$currency )); ?></td>
                <td><?php echo $this->Form->input('client_id', array('disabled'=>$disabled, 'default'=>0)); ?></td>
                <td><?php echo $this->Form->input('tariff_id', array('disabled'=>$disabled, 'default'=>0)); ?></td>
                <td><?php echo $this->Form->input('limit', array('after'=>$currency));?></td>
            </tr>
            <tr>
                <td colspan='4'>
	                <?php echo $this->Form->input('description', array('rows'=>3)); ?>
                </td>
            </tr>
            <tr>
                <td colspan='4'>
                    <?php echo $this->Form->end(__('Submit', true));?>
                </td>
            </tr>
        </table>
	</fieldset>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('RoomSession.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('RoomSession.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Room Sessions', true), array('action' => 'index'));?></li>
	</ul>
</div>
