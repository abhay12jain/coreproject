<?php
require_once '../common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';
$objAdminLogin=Factory::getInstanceOf('AdminLogin');
if(isset($_POST['frmAdminEmail']))
{	
	$objAdminLogin->changeUserEmail($_POST);
	header('location:settings_frm.php');
	exit;
}
// ADMIN PASSWORD IS UPDATING HERE.
if(isset($_POST['btnPasswordUpdate']))
{	
	$objAdminLogin->changeUserPassword($_POST);
	header('location:settings_frm.php');
	exit;

}


// ADMIN PASSWORD IS UPDATING HERE.
if(isset($_POST['btnPageRecordSize']))
{	
	$pageRSize=$objAdminLogin->changePageRecordSize($_POST);
	if($pageRSize){
		$_SESSION['pageRecordSize']=$pageRSize;
	}
	header('location:settings_frm.php');
	exit;

}





?>