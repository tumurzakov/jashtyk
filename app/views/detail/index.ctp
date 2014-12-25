<h2><?php __('Detail statistic by IP address');?></h2> 
<table id="detail-index-frame-table">
    <tr>
        <td id="detail-index-request-form" class="bottom-borderless">
            <?php
                echo $form->create('DetailRequest', array('url'=>array('controller'=>'detail', 'action'=>'index')));
                echo $form->input('ip', array('maxLength'=>15));
                echo $form->input('from', array('dateFormat'=>'DMY', 'timeFormat'=>'none'));
                echo $form->input('to', array('dateFormat'=>'DMY', 'timeFormat'=>'none'));
                echo $form->end(__('Submit', true));
            ?>
        </td>
        <td class="bottom-borderless">
            <?php 
            $paginator->options(array('url' => $this->passedArgs));
            echo $paginator->counter(array( 'format' => __('Page %page% of %pages%, '.
                'showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
            ?>

            <table id="detail-index-request-list">
                <tr>
                    <th><?php echo __("IP address");?></th>
                    <th><?php echo __("Begin date");?></th>
                    <th><?php echo __("End date");?></th>
                    <th><?php echo __("Status");?></th>
                    <th><?php echo __("Description");?></th>
                    <th><?php echo __("Actions");?></th>
                </tr>
                <?php foreach($requests as $request): ?>
                <tr>
                    <td><?php echo $request['DetailRequest']['ip'];?></td>
                    <td><?php echo strftime("%Y-%m-%d", strtotime($request['DetailRequest']['from']));?></td>
                    <td><?php echo strftime("%Y-%m-%d", strtotime($request['DetailRequest']['to']));?></td>
                    <td><?php echo __($request['DetailRequest']['status'], true);?></td>
                    <td><?php echo __($request['DetailRequest']['description'], true);?></td>
                    <td class="table-actions">
                        <?php
                            if (in_array($request['DetailRequest']['status'], array('accepted', 'started'))) {
                                echo $html->link(__('Cancel', true), array('action'=>'cancel', $request['DetailRequest']['id']));
                            }
                            if (in_array($request['DetailRequest']['status'], array('completed'))) {
                                echo $html->link(__('Download', true), 
                                    '/files/detail_request_results/' . basename($request['DetailRequest']['file']));
                            }
                            echo $html->link(__('View', true), array('action'=>'view', $request['DetailRequest']['id']));
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="paging">
                <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
             | 	<?php echo $paginator->numbers();?>
                <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
            </div>
        </td>
    </tr>
</table>
