<?php

require_once './common/config/config.inc.php';

if($_SESSION['sessForgotValues']!='')

{

	$varUserName = $_SESSION['sessForgotValues']['frmUserName'];

}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>Admin Forgot Password</title>

<link href="<?php echo SITE_ROOT_URL;?>/common/css/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo SITE_ROOT_URL;?>/common/css/common.css" rel="stylesheet" type="text/css" />

<link href="<?php echo SITE_ROOT_URL;?>/common/css/tables.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="<?php echo SITE_ROOT_URL;?>admin/common/js/validate.js"></script>



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



<!-- ERROR DIV -->



    <div class="error" style="display:none;">



        <span>Invalid UserName!</span>



        <p> you have entered wrong UserName</p>



    </div>



<!-- ERROR DIV -->		



<table width="550" align="center">



<thead>



<?php



	if($objCore->displaySessMsg() != '')

	{

		echo $objCore->displaySessMsg(); $objCore->setSuccessMsg(''); $objCore->setErrorMsg(''); 

	}?>



<tr><th colspan="2">

Admin Forgot Password

</th>

</tr></thead>

<tr><td>

<!-- LOGIN FORM -->

	<form action="forgot_password_action.php" method="post" id="frm_forgot_pass" onsubmit="return validateForgotPassword('frm_forgot_pass');">

		<fieldset>

			<label><span style="color:#FF0000;">*</span> Username(Email):</label>



			<input type="text" id="frmUserName" name="frmUserName" tabindex="1" class="input" value="<?php echo $varUserName;?>" /><br /> 



			<label >&nbsp;</label><img src="<?php echo SITE_ROOT_URL;?>admin/common/images/security-images/security-images.php" alt=""  /><br />



			<label><span style="color:#FF0000;">*</span> Verification Code:</label><input type="text" id="frmSecurityCode" name="frmSecurityCode" class="input" value="" tabindex="2" /><br />



			<label>&nbsp;</label><small>Enter the characters that are displayed in the image above.</small>



			<label>&nbsp;</label><small>Note: <span style="color:#FF0000;">*</span> Indicates mandatory fields.</small>



			<p class="submit">



			<label></label><input type="submit" tabindex="3" name="btnMailPassword" value="Submit" class="button auto" 	/>



			<input type="button" tabindex="4" value="Cancel" class="button auto" onclick="javascript:location.href='index.php'" style=" margin-left:10px; width:60px;" />



			</p>



			<br /><br />



		</fieldset>



	</form>



	</td></tr></table>



    </div>



<!--  LoginBox End -->



  </div>



<!--  Content End -->  



 



</div>



<!--  Wrapper End -->



</body>



</html>



<?php



?>