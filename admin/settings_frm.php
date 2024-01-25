<?php
require_once '../common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';
$objAdminLogin=Factory::getInstanceOf('AdminLogin');
$varWhr = "AND UserName = '".$_SESSION['sessErpAdminUserName']."'"; 
$arrResult = $objAdminLogin->getUserEmail($varWhr);
if($_SESSION["arrPost"]!='')
{
	@extract($_SESSION["arrPost"]);
	$varAdminEmail = $frmAdminEmail;
	$varAdminSupportEmail = $frmSupportEmail;
}
if($arrResult)
{

	$varAdminEmail = $arrResult[0]['UserEmail'];
	$varAdminSupportEmail = $arrResult[0]['AdminSupportEmail'];
}

//********end here *************************

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Settings</title>
<link href="<?php echo SITE_ROOT_URL;?>/common/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/form.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/tables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITE_ROOT_URL;?>/common/js/validate.js"></script>
<!--[if gte IE 5.5]>
<script language="JavaScript" src="<?php echo SITE_ROOT_URL;?>/common/js/ie.js" type="text/JavaScript"></script>
<![endif]-->
</head>
<body>
<div id="wrapper">
<?php require_once SOURCE_ROOT.'admin/header.inc.php';?>
<!-- settings block -->
<!-- settings Block -->
<div style="clear:both"></div>
<!-- Content Area -->
<div id="middlepart">
<!-- Left column -->
<div id="leftcolumn">
<!-- Success Box -->
<?php

	if($objCore->displaySessMsg())
	{
?>
		<?php echo $objCore->displaySessMsg(); $objCore->setSuccessMsg(''); $objCore->setErrorMsg(''); ?>
<? } ?>

<br />

<!-- Form Box 1 -->

<form action="settings_action.php" method="post" id="frm_password" onsubmit="return validateChangePassword('frm_password');">
<input type="hidden" value="<?php echo $arrResult[0]['PkUserId']; ?>" name="AdminID" />
<fieldset>
<legend>Change Password</legend>
<label><strong>Current Password : </strong></label>
<input type="password" name="frmAdminOldPassword" value="" />
<br />
<label><strong>New Password : </strong></label>
<input type="password" name="frmAdminNewPassword" value="" /> 
( Password must contain only <strong>a-z, A-Z, 0-9, -, _, #, @ or !</strong> characters. ) 
<br />
<label><strong>Confirm Password : </strong></label>
<input type="password" name="frmAdminConfirmPassword" value="" />
<br />
<label style="width:80px;"></label>
<input type="submit" class="button" name="btnPasswordUpdate"  value="Change My Password" />
</fieldset>
</form><!-- Form Box 1 -->
<!-- Left Column -->
<br/>


<!-- Success Box -->
<div class="success" style="display:none;"><span>Congratulations!</span>
<p> This is the style of fonts your can use...</p>
</div>
<!-- Success Box 1-->

<!-- Error Box -->
<div class="error" style="display:none;"><span>Error!</span>
<p> This is the style of fonts your can use...</p>
</div>
<!-- Error Box 1-->


<!-- Form Box 2 -->

<form action="settings_action.php" method="post" id="frm_email" onsubmit="return validateEmailChange('frm_email');">
<fieldset>
<input  type="hidden" value="<?php echo $_SESSION['sessErpAdminDetails'][0]['PkUserId'];?>" name="AdminID" />
<legend>Change Notification Email ID</legend>
<label style="width:160px;"><strong>Notification E-mail Address : </strong></label>
<input type="text" name="frmAdminEmail" value="<?php echo $varAdminEmail; ?>" />
<br />
<label style="width:80px;"></label>
<input type="submit" class="button" name="btnEmailUpdate" value="Change My Email ID" />
</fieldset>
</form>
<!-- Form Box 2 -->

<br/>
<!-- Form Box 3 -->
<form action="settings_action.php" method="post" id="frm_page_record_size" >
<fieldset>
<input  type="hidden" value="<?php echo $_SESSION['sessErpAdminDetails'][0]['PkUserId'];?>" name="AdminID" />
<legend>Change Page Record Size</legend>
<label><strong>Page Record Size</strong></label>
<select name="frmPageRecordSize" style="width:150px">
<option value="10" <?php if(ADMIN_PAGE_RECORD_SIZE=='10'){?> selected="selected"<?php }?>>10</option>
<option value="20" <?php if(ADMIN_PAGE_RECORD_SIZE=='20'){?> selected="selected"<?php }?>>20</option>
<option value="40" <?php if(ADMIN_PAGE_RECORD_SIZE=='40'){?> selected="selected"<?php }?>>40</option>
<option value="60" <?php if(ADMIN_PAGE_RECORD_SIZE=='60'){?> selected="selected"<?php }?>>60</option>
<option value="100" <?php if(ADMIN_PAGE_RECORD_SIZE=='100'){?> selected="selected"<?php }?>>100</option>
</select>
<br />
<label style="width:80px;"></label>
<input type="submit" class="button" name="btnPageRecordSize" value="PageRecordSize" />
</fieldset>
</form> <!-- Form Box 3 -->

</div><!-- Left Column -->
<!-- 
<div id="rightcolumn">
<div class="notes" nowrap="nowrap"><h3><?php echo $varAdminCompName; ?> Admin Panel</h3>
<p>Admin can manage settings.</p>
</div>
</div>
 -->
</div>
</div><!-- Wrapper -->
<?php  require_once SOURCE_ROOT.'admin/footer.inc.php'; ?>
</body>
</html>