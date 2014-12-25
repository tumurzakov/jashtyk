<?php
$clientStatus = array();
foreach($report as $id => $room) {
    foreach($room['sessions'] as $roomSession) {
        if (!isset($clientStatus[$roomSession['RoomSession']['client_id']]))
            $clientStatus[$roomSession['RoomSession']['client_id']] = false;

        $clientStatus[$roomSession['RoomSession']['client_id']] = 
            $clientStatus[$roomSession['RoomSession']['client_id']] ||
            ($roomSession['RoomSessionStatus']['name'] == 'Started');
    }
}
?>

<div class="rooms index">
    <table cellpadding="0" cellspacing="0">
    <tr>
            <th><?php __('Room'); ?></th>
            <th><?php __('Session'); ?></th>
            <th><?php __('Tariff'); ?></th>
            <th><?php echo __('Balance') . " ($currency)"; ?></th>
            <th><?php __('Status'); ?></th>
            <th><?php __(''); ?></th>
    </tr>
    <?php foreach ($report as $id => $room): ?>
    <?php $room['sessions'] = array_merge(array(array()), $room['sessions']); ?>
    <?php foreach ($room['sessions'] as $roomSession): ?>
    <tr class="rooms-room-row">
        <?php if (!isset($room['printed'])): ?>
        <td class='rooms-room' rowspan='<?php echo count($room['sessions']); ?>' >
            <div class='rooms-room-name <?php echo @$room['status'] == 'on' ? 'access-on' : 'access-off';?>'>
                <?php echo isset($room['name']) ? $room['name'] : ''; ?>
            </div>
            <div class='rooms-room-type'><?php echo isset($room['type_name']) ? $room['type_name'] : ''; ?></div>
            <?php $room['printed'] = true; ?>
        </td>
        <?php endif; ?>
        <?php if (count($roomSession)): ?>
            <td class='rooms-room-sessions'>
                <div class='rooms-room-session-name 
                    <?php echo $roomSession['RoomSessionStatus']['name'] == 'Started'?'rooms-room-active-session':''; ?>'>
                    <?php echo $roomSession['RoomSession']['name']; ?></div> 
                <div class='rooms-room-period'>
                    <?php printf(__("From %s to %s", true), 
                        array_shift(split(' ', $roomSession['RoomSession']['start'])), 
                        array_shift(split(' ', $roomSession['RoomSession']['end'])));
                    ?></div>
            </td><td class='rooms-room-tariff'>
                <?php echo $roomSession['Tariff']['name']; ?>
            </td><td class='rooms-room-balance'>
                <?php printf("%.2f", $roomSession['RoomSession']['balance'] - $roomSession['usage']['usage']); ?>
            </td><td class='rooms-room-status'>
                <?php __($roomSession['RoomSessionStatus']['description']); ?>
            </td><td class="actions">
                <?php 
                    $occupied = $clientStatus[$roomSession['RoomSession']['client_id']];
                    if ($roomSession['RoomSession']['client_id'] && $room['type'] == 'room') {
                        if ($roomSession['RoomSessionStatus']['name'] == 'Not started' && !$occupied) {
                            echo $this->Html->link(__('Start now', true), array('action' => 'startNow', $roomSession['RoomSession']['id']), null, __('Are you sure want to start session?', true));
                        } else if (in_array($roomSession['RoomSessionStatus']['name'], array('Started'))) {
                            echo $this->Html->link(__('End now', true), array('action' => 'endNow', $roomSession['RoomSession']['id']), null, __('Are you sure want to stop session?', true));
                        }
                    }
                ?>
                <?php echo $this->Html->link(__('View', true), array('action' => 'view', $roomSession['RoomSession']['id']));?>
                <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $roomSession['RoomSession']['id']));?>
            </td>
        <?php else: ?>
            <td colspan='6'></td>
        <?php endif; ?>
    </tr>
    <?php endforeach;?>
    <?php if ($id): ?><tr><td class='rooms-room-row' colspan=7></td></tr><?php endif; ?>
    <?php endforeach;?>
    </table>
</div>

<div class="actions">
    <div class='room-sessions-filter'>
        <?php
        echo $form->create('RoomSession', array('action'=>"index"));
        echo $form->input('filter', array('maxLength'=>50));
        echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'MY', 'minYear'=>'2010', 'maxYear'=>'2020')); 
        echo $form->end(__('Filter', true));
        ?>
    </div>

	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Add Session', true), array('action' => 'add'));?></li>
	</ul>
</div>
