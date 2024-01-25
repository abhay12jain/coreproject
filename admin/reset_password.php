<?php 



require_once './common/config/config.inc.php';

if(isset($_GET['code']) && isset($_GET['mid']))

{

	$arrColumns = array('PkUserId');

	$varWhereCondition = 'PkUserId = \''.$_GET['mid'].'\' AND UserForgotPWCode = \''.$_GET['code'].'\'';

	$arrMemberDetails = $objGeneral->getRecord(TABLE_ADMIN, $arrColumns, $varWhereCondition);

	

}

else if($_GET['op'] != 'result')

{

	//if no GET parameters, we skip to the index page.

	header('location:index.php');

	exit;



}?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Admin Login</title>

<link href="<?php echo SITE_ROOT_URL;?>/common/css/style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo SITE_ROOT_URL;?>/common/css/common.css" rel="stylesheet" type="text/css" />

<link href="<?php echo SITE_ROOT_URL;?>/common/css/tables.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="js/validate.js"></script>

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

        <span>Invalid Login!</span>

	     <p> you have entered wrong username or password!</p>

    </div>

<!-- ERROR DIV -->		

<table width="550" align="center">

<thead>

<?php

	if($objCore->displaySessMsg() != '')

	{?>

		<div align="left">

		<?php echo $objCore->displaySessMsg(); $objCore->setSuccessMsg(''); $objCore->setErrorMsg(''); ?>

		</div><?php

	}?>



<tr><th colspan="2">

Admin  Panel Reset Password

</th>

</tr></thead>

<tr><td>

<?php 

	if($arrMemberDetails)

	{?>

		<div id="login"><br />



		<form action="reset_password_action.php" method="post" id="frm_reset_pass" onsubmit="return validateResetPassword('frm_reset_pass');">



			<fieldset>



				<label> <span style="color:#FF0000;">*</span>New Password : </span></label>



				<input type="password" id="frmNewPassword" name="frmNewPassword" tabindex="1" value=""/>  



				<br /><br />



				<label><span style="color:#FF0000;">*</span>Confirm New Password : </label>



				<input type="password" id="frmConfirmNewPassword" name="frmConfirmNewPassword" value="" tabindex="2" /><br /><br />



				<label>&nbsp;</label><small>Password must contain only a-z, A-Z, 0-9, -, _, #, @ or ! characters. )</small>



				<label>&nbsp;</label><small>Note: <span style="color:#FF0000;">*</span> Indicates mandatory fields.</small>



				<label></label>



				<p class="submit">



				<input type="hidden" name="fgtPwdStatusCode" value="<?php echo $_GET['code'];?>" />



				<input type="submit" tabindex="3"  name="btnResetPassword" value="Save" class="button auto" /></p>



				<br /><br />



			</fieldset>



		</form>



		</div>



	<?php

	}

	else if($_GET['op'] == 'result')

	{?>

		<div id="login"><br />

			<form>

				<fieldset>

				<div class="success" style="margin-top:25px;text-align:left">Your password has been reset successfully. You can now <a href="index.php">login</a> with your new password.</div><br /><br />

				</fieldset>

			</form>

		</div><?php

	}

	else

	{?>

		<div id="login"><br />

		<form>

		  <fieldset>

			<div class="error" style="margin-top:25px;text-align:left">The link for resetting your password is incorrect or it is expired. Kindly check the link you followed.</div><br /><br />

			</fieldset>

		  </form>

		</div><?php

	}?>		

	</td></tr></table>

    </div>

<!--  LoginBox End -->

  </div>

<!--  Content End -->  

</div>

<!--  Wrapper End -->

</body>

</html>

