<?php $this->Session->delete('active_room_session'); ?>
<h2><?php __('Table of contents'); ?></h2>
<table>
    <?php if (in_array($AuthGroup['Group']['name'], array('administrators', 'operators'))): ?> 
    <tr>
        <th id='home-table-of-contents-name'><?php __('Name'); ?></th>
        <th><?php __('Description'); ?></th>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Traffic usage by guest", true), array('controller'=>'room_sessions')); ?></td>
        <td><?php echo __(
            "Internet service management tool for guests"
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Traffic usage by room", true), array('controller'=>'traffic')); ?></td>
        <td><?php echo __(
            "This report shows how much traffic use this month each room and gives detailed ".
            "explanation about when this traffic were used"
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Payments", true), array('controller'=>'payments')); ?></td>
        <td><?php echo __("Recent customer payments"); ?> </td>
    </tr>

    <tr>
        <td><?php echo $html->link(__("Channel Speed Chart", true), array('controller'=>'channel_speed')); ?></td>
        <td><?php echo __(
            "Graphical representation of Internet service usage"
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Raw statistic", true), array('controller'=>'detail')); ?></td>
        <td><?php echo __(
            "Detailed statistic generating tool. It compiles an arhive with raw data by specified ".
            "IP adress and period"
            ); ?> </td>
    </tr>

    <?php endif; ?>

    <?php if (in_array($AuthGroup['Group']['name'], array('administrators'))): ?> 
    <tr>
        <td><?php echo $html->link(__("Client management", true), array('controller'=>'clients')); ?></td>
        <td><?php echo __(
            "There is a tool for inserting, editing and deleting users from billing" 
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Tariff management", true), array('controller'=>'tariffs')); ?></td>
        <td><?php echo __(
            "There is a tool for inserting, editing and deleting tariffs" 
            ); ?> </td>
    </tr>

    <tr>
        <td><?php echo $html->link(__("Peering networks", true), array('controller'=>'peerings')); ?></td>
        <td><?php echo __(
            "Traffic to this networks comes through billing without accounting"
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("Billing networks", true), array('controller'=>'networks')); ?></td>
        <td><?php echo __(
            "Networks that we use for our clients"
            ); ?> </td>
    </tr>
    <tr>
        <td><?php echo $html->link(__("MAC-IP Binding", true), array('controller'=>'ips')); ?></td>
        <td><?php echo __(
            "Binding computer by unique network address"
            ); ?> </td>
    </tr>


    <tr>
        <td><?php echo $html->link(__("Settings", true), array('controller'=>'configs')); ?></td>
        <td><?php echo __(
            "Various configuration variables"
            ); ?> </td>
    </tr>

    <tr>
        <td><?php echo $html->link(__("Users", true), array('controller'=>'users')); ?></td>
        <td><?php echo __(
            "System user management"
            ); ?> </td>
    </tr>
    <?php endif;?>
</table>
