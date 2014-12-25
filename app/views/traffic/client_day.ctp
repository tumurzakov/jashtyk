<table><tr><td class="traffic-detail-ip-list">
    <div class="traffic-menu">
        <p><?php echo $html->link(__('Back', true), array('action'=>'client_month', $clientId, $selectedIp, $day));?></p>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td <?php echo $selectedIp == 'all' ? 'class="traffic-selected-ip"' : ''?>>
                <?php echo $html->link(__('All', true), array('action'=>'client_day', $clientId, 'all', $day)); ?>
            </td>
        </tr>

        <?php
        $i = 0;
        foreach ($client['Ip'] as $ip):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>
            <td <?php echo $selectedIp == $ip['ip'] ? 'class="traffic-selected-ip"' : ''?>>
                <?php echo $html->link($ip['ip'], array('action'=>'client_day', $clientId, $ip['ip'], $day));?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</td><td>
    <div class="traffic-detail-report">
        <?php
        echo $form->create(null, array('action'=>"client_day"));
        echo $form->input('clientId', array('type'=>'hidden', 'value'=>$clientId));
        echo $form->input('ip', array('type'=>'hidden', 'value'=>$selectedIp));
        echo $form->input('month', array('label'=>'', 'type'=>'date', 'dateFormat'=>'DMY', 
            'minYear'=>'2010', 'maxYear'=>'2020', 'selected'=>$day)); 
        echo $form->end(__('Report', true));
        ?>
    </div>

    <table cellpadding="0" cellspacing="0">
    <tr>
            <th><?php echo $this->Paginator->sort('time');?></th>
            <th><?php echo $this->Paginator->sort('ip');?></th>
            <th><?php echo $this->Paginator->sort('global_in');?></th>
            <th><?php echo $this->Paginator->sort('global_out');?></th>
            <th><?php echo $this->Paginator->sort('peering_in');?></th>
            <th><?php echo $this->Paginator->sort('peering_out');?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($report as $detail):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
    <tr<?php echo $class;?>>
        <td><?php echo strftime("%F %T", $detail['TrafficDetail']['time']);?></td>
        <td><?php echo $detail['TrafficDetail']['ip'];?></td>
        <td><?php echo $traffic->format($detail['TrafficDetail']['global_in']);?></td>
        <td><?php echo $traffic->format($detail['TrafficDetail']['global_out']);?></td>
        <td><?php echo $traffic->format($detail['TrafficDetail']['peering_in']);?></td>
        <td><?php echo $traffic->format($detail['TrafficDetail']['peering_out']);?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array(
    'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
    ));
    ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $this->Paginator->numbers();?>
 |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
    </div>

</td></tr></table>
