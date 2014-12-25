<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Golden Dragon Network Billing'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('monitoring');
		echo $this->Html->script('jquery.js');
    ?>
    <!--[if IE]><script language="javascript" type="text/javascript" 
        src="<?php echo $this->base;?>/js/jqPlot/excanvas.min.js"></script><![endif]-->
    <?php
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo __('Golden Dragon Network Billing', true); ?></h1>
			<div id="quick-menu">
                <?php echo $this->Html->link(__("Traffic usage by guest", true), 
                    array('controller'=>'room_sessions', 'action'=>'index')); ?>
                <?php echo $this->Html->link(__('Table of contents', true), '/'); ?>
                <?php 
                    $location = array('controller'=>$this->params['controller'], 'action'=>$this->params['action']);
                    $location = array_merge($location, $this->params['pass']);
                    echo $this->Html->link(__('Refresh', true), $location); 
                ?>
                <?php echo $this->Html->link(__('Logout', true), array('controller'=>'users', 'action'=>'logout')); ?>
                <div id="header-username"><?php echo isset($AuthUser['User'])? sprintf(__("You have entered as %s", true), $AuthUser['User']['username']) : ""; ?></div>
            </div>
		</div>
		<div id="content">

            <?php echo $session->flash(); ?>
			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
