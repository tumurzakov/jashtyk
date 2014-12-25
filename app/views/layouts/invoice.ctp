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
    ?>
    <?php echo $scripts_for_layout; ?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo __('Golden Dragon Network Billing', true); ?></h1>
			<div id="quick-menu">&nbsp;</div>
		</div>
		<div id="content">
			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
