<table>
    <tr>
        <th><?php __('Field'); ?></th>
        <th><?php __('Value'); ?></th>
    </tr>
    <tr>
        <td><?php __("Id"); ?></td>
        <td><?php echo $request['DetailRequest']['id']; ?></td>
    </td>
    <tr>
        <td><?php __("IP address"); ?></td>
        <td><?php echo $request['DetailRequest']['ip']; ?></td>
    </td>
    <tr>
        <td><?php __("Begin date"); ?></td>
        <td><?php echo $request['DetailRequest']['from']; ?></td>
    </td>
    <tr>
        <td><?php __("End date"); ?></td>
        <td><?php echo $request['DetailRequest']['to']; ?></td>
    </td>
    <tr>
        <td><?php __("Status"); ?></td>
        <td><?php echo $request['DetailRequest']['status']; ?></td>
    </td>
    <tr>
        <td><?php __("Description"); ?></td>
        <td><?php echo $request['DetailRequest']['description']; ?></td>
    </td>
    <tr>
        <td><?php __("Created"); ?></td>
        <td><?php echo $request['DetailRequest']['created']; ?></td>
    </td>
    <tr>
        <td><?php __("Started"); ?></td>
        <td><?php echo $request['DetailRequest']['started']; ?></td>
    </td>
    <tr>
        <td><?php __("Completed"); ?></td>
        <td><?php echo $request['DetailRequest']['completed']; ?></td>
    </td>
    <tr>
        <td><?php __("File"); ?></td>
        <td><?php echo $request['DetailRequest']['file']; ?></td>
    </td>
</table>
<?php echo $html->link(__("Back", true), array('action'=>'index')); ?>
