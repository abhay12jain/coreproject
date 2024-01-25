<?php
require_once './common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';

$objAdminLogin=Factory::getInstanceOf('AdminLogin');

/* This is used to forgot password purpose */

if(isset($_POST['btnMailPassword']))

{

	$objAdminLogin->forgotPasswordMail($_POST);

	header('location:forgot_password.php');	

	exit;

}



?>