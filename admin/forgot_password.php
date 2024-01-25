<?php

require_once './common/config/config.inc.php';

if($_SESSION['sessForgotValues']!='')

{

	$varUserName = $_SESSION['sessForgotValues']['frmUserName'];

}
?>

<html lang="en" class="fullscreen-bg">
<head>

	<title>Forgot PassWord</title>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- VENDOR CSS -->

	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="./assets/vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="./assets/vendor/linearicons/style.css">

	<!-- MAIN CSS -->

	<link rel="stylesheet" href="./assets/css/main.css">

	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->

	<link rel="stylesheet" href="assets/css/demo.css">

	<!-- GOOGLE FONTS -->

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

	<!-- ICONS -->

	<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">

	<link rel="icon" type="image/png" sizes="96x96" href="./assets/img/favicon.png">

	<script language="javascript" src="<?php echo SITE_ROOT_URL;?>/common/js/validate.js"></script>

</head>
<body>
	<div id="wrapper">
		<div class="error" style="display:none;">



        <span>Invalid UserName!</span>



        <p> you have entered wrong UserName</p>



       </div>
      <?php
        if($objCore->displaySessMsg() != ''){
         echo $objCore->displaySessMsg(); $objCore->setSuccessMsg(''); $objCore->setErrorMsg(''); 
      }?>



		<div class="vertical-align-wrap">

			<div class="vertical-align-middle">

				<div class="auth-box ">

					<div class="left">

						<div class="content">
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


						</div>

					</div>

					<div class="right">

						<div class="overlay"></div>

						<div class="content text">

							<h1 class="heading">FORGOT PASSWORD SECTION</h1>

							<p>Funeral Home</p>

						</div>

					</div>

					<div class="clearfix"></div>

				</div>

			</div>

		</div>

	</div>

	</body>



</html>
