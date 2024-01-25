<?php
require_once './common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';
$objAdminLogin=Factory::getInstanceOf('AdminLogin');
if($_POST['action'])
{
	if($objAdminLogin->doAdminLogin($_POST))
	{		
		header('location:welcome.php');
	}	
	else
	{
		header('location: index.php');
	}			
}
else
{
	header('location:index.php');
}
die;

?>