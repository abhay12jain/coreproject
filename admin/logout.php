<?php
require_once 'common/config/config.inc.php';
require_once SOURCE_ROOT.'common/classes/class.admin_login.php';
$objAdminLogin=Factory::getInstanceOf('AdminLogin');
$objAdminLogin->doAdminLogout();
 $_SESSION['isAdmin'];
 if($_SESSION['isAdmin']!=1){
	 header('location:index.php');
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Logout</title>
<link href="<?php echo SITE_ROOT_URL;?>/common/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL?>/common/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_ROOT_URL?>/common/css/tables.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo SITE_ROOT_URL;?>/common/js/validate.js"></script>
</head>
<body class="login">
<div id="wrapper">
<!-- Header -->
<div id="header">
</div>
<!-- Header -->
<!--  Menu -->
  <div id="menu"> </div>
<!--  Menu -->
  <div style="clear:both"></div>
<!--  Content -->
  <div id="middlepart">
<!--  Login Box -->
   <div id="login">	
<table width="550" align="center">
<thead>
<tr><th colspan="2">
Admin  Panel Logout
</th>
</tr></thead>
<tr><td>
<!-- LOGIN FORM -->
        <fieldset>
		<br /><br /><br />
		<label style="width:390px; padding-left:15px; margin:0 auto 0 auto;">You have been successfully logged out.&nbsp; 
        <a href="<?php echo SITE_ROOT_URL;?>admin/index.php"><span style="font-size:14px; font-weight:bold;">Click here</span></a>&nbsp; to login again.</label>
		<br /><br /><br /><br />
		</fieldset>
	</td></tr></table>
    </div>
<!--  LoginBox End -->
  </div>
<!--  Content End -->  
</div>
<!--  Wrapper End -->
</body>
</html>
