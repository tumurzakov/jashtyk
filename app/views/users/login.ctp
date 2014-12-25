<div class="login form">
<?php echo $form->create('User', array('action' => 'login'));?>
	<fieldset>
 		<legend><?php __('Login');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password');
	?>
	</fieldset>
<?php echo $form->end(__('Login', true));?>
