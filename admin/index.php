<?php
require_once './common/config/config.inc.php';
?>

<!doctype html>

<html lang="en" class="fullscreen-bg">



<head>

	<title>Login</title>

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

 <?php

    $objCore = Factory::getInstanceOf('Core');

    

   //echo "!!!!!!!!!!!111".  $_SESSION['sessErpAdminDetails'][0]['UserName'];

    if(isset($_SESSION['sessErpAdminDetails'][0]['UserName'])){

	header("location:welcome.php");
exit();
}

?>

	<!-- WRAPPER -->

	<div id="wrapper">

		<div class="vertical-align-wrap">
			
			<div class="vertical-align-middle">
				<?php if ($objCore->displaySessMsg()) {

        echo $objCore->displaySessMsg();

        $objCore->setSuccessMsg('');

        $objCore->setErrorMsg('');

    }?>


				<div class="auth-box ">

					<div class="left">

						<div class="content">

							<div class="header">

								<div class="logo text-center"><img src="./assets/img/logo.png" alt="funeral Logo"></div>

								<p class="lead">Login to your account</p>

							</div>

							<form class="form-auth-small loginform" action="login_action.php" method="post" onsubmit="return validate_admin_login_form('loginform');" name="loginform" id="loginform">

                             <input type="hidden" name="action" value="login" />

								<div class="form-group">

									<label for="signin-email" class="control-label sr-only">Username</label>

									<input type="text" class="form-control input" id="signin-email" id="frmAdminUserName" name="frmAdminUserName" value="" placeholder="Email">

								</div>

								<div class="form-group">

									<label for="signin-password" class="control-label sr-only">Password</label>

									<input type="password" class="form-control input" id="signin-password" id="frmAdminPassword" name="frmAdminPassword" value="" placeholder="Password">

								</div>

								<div class="form-group clearfix">

									<label class="fancy-checkbox element-left">

										<input type="checkbox">

										<span>Remember me</span>

									</label>

								</div>

								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>

								<div class="bottom">

									<span class="helper-text"><i class="fa fa-lock"></i> <a href="forgot_password.php">Forgot password?</a></span>

								</div>

							</form>

						</div>

					</div>

					<div class="right">

						<div class="overlay"></div>

						<div class="content text">

							<h1 class="heading">Login Section</h1>

							<p>Funeral Home</p>

						</div>

					</div>

					<div class="clearfix"></div>

				</div>

			</div>

		</div>

	</div>

	<!-- END WRAPPER -->

</body>



</html>

<style type="text/css">
	.error {
    background: #ffe3e1 url(../admin/common/images/error.gif) no-repeat 12px 50%;
    border: 1px solid #f14545;
    border-width: 5px 0 0 0;
    color: #f14545;
}
.error span {
    font-weight: bold;
    font-size: 18px;
    padding: 2px 40px;
}
.success p, .error p, .notice p {
    margin: 0;
    padding: 0 56px;
    color: #333333;
}
.vertical-align-middle .error {

padding: 15px 0px;
width: 70%;
margin: 0 auto 30px auto;
}
</style>