<div class="roomSessions form">
<?php echo $this->Form->create('RoomSession');?>
	<fieldset>
 		<legend><?php __('Add Room Session'); ?></legend>
        <table>
            <tr>
                <td colspan='4'><?php echo $this->Form->input('name'); ?>
            </tr>
            <tr>
                <td colspan='2'><?php echo $this->Form->input('start', 
                    array('dateFormat'=>'DMY', 'timeFormat'=>24)); ?></td>
                <td colspan='2'><?php echo $this->Form->input('end', 
                    array('dateFormat'=>'DMY', 'timeFormat'=>24, 
                    'selected'=>strftime("%F 12:00", strtotime("+1 day")))); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('client_id', array('default'=>0)); ?></td>
                <td><?php echo $this->Form->input('tariff_id', array('default'=>0)); ?></td>
                <td><?php echo $this->Form->input('limit', array('after'=>$currency)); ?></td>
                <td></td>
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
            </table>
	</fieldset>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Room Sessions', true), array('action' => 'index'));?></li>
	</ul>
</div>
