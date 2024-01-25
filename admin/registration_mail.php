<?php
require_once '../common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';
$objAdminLogin=Factory::getInstanceOf('AdminLogin');
$objEmailTemplate = new EmailTemplate();
//GET THE ALL FIELDS VALUES FROM DATABASE TABLE AND STORE THEM IN A VARIABLE TO UPDATE
  $arrCol = array('pkEmailTemplateID', 'EmailTemplateSubject', 'EmailTemplateDescription');
  $varWhere = ' 1 AND pkEmailTemplateID =\'3\' AND EmailTemplateStatus=\'Active\'';
  $arrResult = $objGeneral->getRecord(TABLE_EMAIL_TEMPLATES, $arrCol, $varWhere);
  //print_r($arrResult[0]);
  @extract($arrResult[0]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registration Mail</title>
<!--[if gte IE 5.5]>
    <script language="JavaScript" src="<?php echo SITE_ROOT_URL;?>/common/js/ie.js" type="text/JavaScript"></script>
<![endif]-->

<link href="<?php echo SITE_ROOT_URL;?>/common/css/menu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/form.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL;?>/common/css/tables.css" rel="stylesheet" type="text/css" />
<style type="text/css">
label { width:300px; }
</style>
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
<?php
	if($objCore->displaySessMsg())
	{
		 echo $objCore->displaySessMsg(); $objCore->setSuccessMsg(''); $objCore->setErrorMsg(''); 
	} 
?>
<!-- Form Box 1 -->
<form  name="category_frm" id="category_frm"  method="post" action="email_template_action.php"  >
<fieldset>


<legend> Registration Mail Content</legend>

<label><strong>Enter Subject: </strong></label>
<input type="text" style="width:500px;" name="EmailTemplateSubject" id="EmailTemplateSubject" value="<?php  echo $EmailTemplateSubject; ?>" />
<br />
<label><strong>Enter Message: </strong></label>
<textarea name="EmailTemplateDescription" id="EmailTemplateDescription" cols="60" rows="8"><?php echo $EmailTemplateDescription;?></textarea>
<br />
<label>&nbsp;</label><strong>Site automatically replace {SiteName} type fields</strong>
<br />
<label>&nbsp;</label>
<input type="hidden" name="type" value="registration" />
<input type="hidden" name="pkEmailTemplateID" id="pkEmailTemplateID" value="<?php echo $pkEmailTemplateID;?>" />
<input type="submit" value="Submit" name="frmSubmit" id="frmSubmit" class="button" />
<input type="button" value="Cancel" class="button" onclick="history.go(-1);return false;" />
</fieldset>
</form>
<!-- Form Box 2 -->
<!-- Left Column -->
</div>
<!-- Right Column -->
<div id="rightcolumn">
  <!-- Notes / Articles Box -->
<div class="notes"><h3><?php echo $varAdminCompName; ?> Admin Panel</h3>
<p>Here Admin Can Edit Mail Content</p>
</div>
 <!-- Notes / Articles Box -->
</div>
<!-- Content -->
</div>
</div>
<!-- Wrapper -->
<?php require_once('footer.inc.php');?>
</body>
</html>