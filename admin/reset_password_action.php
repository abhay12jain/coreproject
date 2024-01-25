<?php

require_once './common/config/config.inc.php';

require_once SOURCE_ROOT.'common/classes/class.admin_login.php';

$objAdminLogin=Factory::getInstanceOf('AdminLogin');

if(isset($_POST['btnResetPassword']))

{

	if($objAdminLogin->resetPassword($_POST))

    {

	 	header('location:reset_password.php?op=result');	

	 	exit;

	}

	else

	{

		header('location:'.$_SERVER['HTTP_REFERER']);	

		exit;

	}



}



?>