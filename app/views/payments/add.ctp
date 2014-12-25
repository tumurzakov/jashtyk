<div class="payments form">
<?php echo $this->Form->create('Payment');?>
	<fieldset>
 		<legend><?php __('Add Payment'); ?></legend>
        
        <div class='payment-session'><?php echo $roomSession['RoomSession']['name']; ?></div>

        <?php
            echo $this->Form->input('room_session_id', array('type'=>'hidden', 
                'value'=>$roomSession['RoomSession']['id']));
            echo $this->Form->input('amount', array('after'=>$currency));
            echo $this->Form->input('description', array('rows'=>3));
        ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

        <?php if($this->Session->check('active_room_session')): ?>
		    <li><?php echo $this->Html->link(__('Session', true), array('controller'=>'room_sessions', 'action' => 'view', $this->Session->read('active_room_session'))); ?></li>
		    <li><?php echo $this->Html->link(__('Payments', true), array('controller'=>'payments', 'action' => 'index', $this->Session->read('active_room_session'))); ?> </li>
        <?php else: ?>
		    <li><?php echo $this->Html->link(__('Payments', true), array('controller'=>'payments', 'action' => 'index')); ?> </li>
        <?php endif;?>

	</ul>
</div>
