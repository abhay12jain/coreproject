<?php

class AdminLogin extends Database

{		

	private $objCore;

	private $objValid;	

	private $objEmailTemplate;

	private $objGeneral;

	function __construct()

	{

		parent::__construct();

	   $this->objCore =Factory::getInstanceOf('Core');	 

	   $this->objValid =Factory::getInstanceOf('Validate_fields');

	   $this->objEmailTemplate =Factory::getInstanceOf('EmailTemplate');

	   $this->objGeneral =Factory::getInstanceOf('General'); 

	}

	

	function doAdminLogin($argArrPOST)

	{		

		

		if(isset($argArrPOST))

		{

			//server side validation

			$varReturnValue = $this->getLoginValidation($argArrPOST);

			if(!$varReturnValue)

			{

				return false;

			}

			

			$varUserName = $argArrPOST['frmAdminUserName'];

			$varUserPassword = $argArrPOST['frmAdminPassword'];

			//verifying admin into database 

			$varWhereCondition = " AND UserName = binary '".$varUserName."' AND UserPassword = '".$varUserPassword."'";

			$arrUser = $this->getUserInfo($varWhereCondition);

		    

			if($arrUser!=NULL)

			{

			  if($arrUser[0]['Status'] == 'y') {

					$_SESSION['sessErpAdminDetails'] = $arrUser;

					$_SESSION['pageRecordSize']=$arrUser[0]['UserPageRecordSize'];

					$_SESSION['sessErpAdminUserName'] = $varUserName;

					$_SESSION['isAdmin'] = true;

					

					//insert entry for last login data 

					$varIpAddress = $_SERVER['REMOTE_ADDR'];

					$varRandom = rand(0, 1000);	

					$arrColumns = array('UserLastLogin'=>date("Y-m-d H:i:s"), 'UserLastLoginIPAddress'=>$varIpAddress,'UserForgotPWCode'=>$varRandom);

					$varWhereCondition = "PkUserId = '".$_SESSION['sessErpAdminDetails'][0]['PkUserId']."'";

					

					$this->update(TABLE_ADMIN,$arrColumns,$varWhereCondition);

					// after successfull login return true to redirect to dashboard 

					return true;

			       }

				  else 

				  {

					  $this->objCore->setErrorMsg(USERS_LOGIN_STATUS_ERR);		

					  return false;

					   

				  }

			}

			else

			{

					//else return false to redirect to login form page

					$this->objCore->setErrorMsg(USER_LOGIN_ERROR);		

					return false;

			}

			

		}

		else

		{

			$this->objCore->setErrorMsg(USER_LOGIN_ERROR);

			return false;

		}	

	}

	

	function getFormatedModuleData($argResult) {

		$arrFormatedResult=array();

		for($i=0;$i<count($argResult);$i++){

			$arrFormatedResult[$argResult[$i]['PkCompanyModuleID']]=$argResult[$i]['CompanyModuleName'];

		}

		return $arrFormatedResult;

	}

	

	

	function getLoginValidation($argArrPOST)

	{

	  	$this->objValid->check_4html = true;

		

		$this->objValid->add_text_field('User Name', strip_tags($argArrPOST['frmAdminUserName']), 'text', 'y',30);

    	$this->objValid->add_text_field('Password', strip_tags($argArrPOST['frmAdminPassword']), 'text', 'y',20);

	  	if(!($this->objValid->validation())) 

		{

			 $errorMsg = $this->objValid->create_msg();

			 $this->objCore->setErrorMsg($errorMsg);				

			 return false;	

		} 

	   	else

		{

		   return true;

		}  

	}

	

	

	function getUserInfo($argWhere) 

	{

		$arrClms = array('PkUserId', 'UserFirstName', 'UserLastName', 'UserName','UserPassword', 'UserEmail','UserLastLogin', 'Status', 'UserLastLoginIPAddress', 'UserForgotPWCode','UserPageRecordSize');

		$varWhere = '1 ' . $argWhere;

		$arrUserResults = $this->select(TABLE_ADMIN, $arrClms, $varWhere);

		//print_r($arrUserResults);die;

		return $arrUserResults;

	}

		

	

	function changePageRecordSize($arrPostData){

		$arrClms = array('UserPageRecordSize'=>$arrPostData['frmPageRecordSize']);

		$varWhere = '1 AND PkUserId='.$arrPostData['AdminID'];

		$status= $this->update(TABLE_ADMIN, $arrClms, $varWhere);

		if($status){

			$this->objCore->setSuccessMsg('<p>Page record size updated successfully.</p>');

			return $arrPostData['frmPageRecordSize'];

		}else{

			return false;

		}

			

	}

	

	function getAdminNumRows($argWhrCon)

	{

		 $varAdminClmn = 'PkUserId';

		 $varNumRows = $this->getNumRows(TABLE_ADMIN, $varAdminClmn, $argWhrCon);

		 return $varNumRows;

	}

	

  function forgotPasswordMail($argArrPOST)

	{

		

		$objValid->check_4html = true;

		

		$_SESSION['sessForgotValues'] = array();			

		

		$this->objValid->add_text_field('Username (E-mail) ', strip_tags($argArrPOST['frmUserName']), 'email', 'y',255);

    	$this->objValid->add_text_field('Verification Code', strip_tags($argArrPOST['frmSecurityCode']), 'text', 'y',255);

		

		if(!($this->objValid->validation())) 

		{

			 $errorMsg = $this->objValid->create_msg();

			 $_SESSION['sessForgotValues'] = $argArrPOST; #*

		     $this->objCore->setErrorMsg($errorMsg);				

			 return false;

		}

			if(($_SESSION['security_code'] == $argArrPOST['frmSecurityCode']) && (!empty($_SESSION['security_code'])))

			{

				$varWhereCond = "AND UserEmail  ='".$argArrPOST['frmUserName']."'";

				$userInfo = $this->getUserInfo($varWhereCond);

				

				if($userInfo != NULL)

				 {					

					

				  $varUserID = $userInfo['0']['PkUserId'];

				  

					  //memberdata contain member username

					  $varMemberData = trim(strip_tags($argArrPOST['frmUserName']));

	                  $varForgotPasswordCode = $this->objGeneral->getValidRandomKey(TABLE_ADMIN, array('PkUserId'), 'UserForgotPWCode', '25');

	                  $varForgotPasswordLink = '<a href="'.SITE_ROOT_URL.'admin/reset_password.php?mid='.$varUserID.'&code='.$varForgotPasswordCode.'">'.SITE_ROOT_URL.'admin/reset_password.php?mid='.$varUserID.'&code='.$varForgotPasswordCode.'</a>'; 

					  

					  $arrColumns = array('Status'=>'y', 'UserForgotPWCode'=>$varForgotPasswordCode);

	                  $varWhereCondition = 'PkUserId = \''.$varUserID.'\'';

	                  $this->update(TABLE_ADMIN, $arrColumns, $varWhereCondition);

					  $varAdminEmail = $userInfo[0]['UserEmail'];

					  $varToUser = $varAdminEmail;

					  $varFromUser = SITE_NAME. "." .$varAdminEmail ;

					  $varSiteName = SITE_NAME;

					  $varWhereTemplate = ' EmailTemplateTitle= \'Admin forgot password\' AND EmailTemplateStatus = \'Active\' ';

					  $arrMailTemplate = $this->objEmailTemplate->getTemplateInfo($varWhereTemplate);

					  $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

					  $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

					  /********/

					  $varSubject = str_replace('{PROJECT_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

	                  $varKeyword = array('{IMAGE_PATH}', '{MEMBER}', '{PROJECT_NAME}', '{USER_DATA}', '{FORGOT_PWD_LINK}', '{SITE_NAME}');

	                  $varKeywordValues = array($varPathImage, 'Admin', SITE_NAME, $varMemberData, $varForgotPasswordLink, SITE_NAME);

	                  $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

					 //Calling mail function

					  //$varToUser . $varFromUser . $varSubject . $varOutPutValues;
                    
					 $this->objCore->sendMail($varToUser,$varFromUser,$varSubject,$varOutPutValues);

					 $_SESSION['sessForgotValues'] = '';	

					 $this->objCore->setSuccessMsg(ADMIN_FORGOT_PASSWORD_CONFIRM_MSG);

					 return true;

				}

				else

				{

					$_SESSION['sessForgotValues'] = $argArrPOST;

					$this->objCore->setErrorMsg(EMAIL_NOT_EXIST_MSG);

					return true;

				}

			}

			else

			{

				$_SESSION['sessForgotValues'] = $argArrPOST;

				$this->objCore->setErrorMsg(INVALID_SECURITY_CODE_MSG);

				return false;

			}

			

	}		

	

	



	function changeUserPassword($argArrPOST)

	{

		$this->objValid->check_4html = true;

		$_SESSION["arrChangePassword"] = array();

			

		$varOldPassword = $argArrPOST['frmAdminOldPassword'];

		$varNewPassword = $argArrPOST['frmAdminNewPassword'];

		$varConfirmPassword = $argArrPOST['frmAdminConfirmPassword'];

		

		//*** server side validation will start from here .

		$this->objValid->add_text_field('Current Password', strip_tags($argArrPOST['frmAdminOldPassword']), 'text', 'y',100);

		$this->objValid->add_text_field('New Password', strip_tags($argArrPOST['frmAdminNewPassword']), 'text', 'y',100);

		$this->objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST['frmAdminConfirmPassword']), 'text', 'y',100);

			

		if(!($this->objValid->validation())) 

		{

			 $errorMsg = $this->objValid->create_msg();

	

		} 

		

		if($varNewPassword != '' && $varConfirmPassword != '')	

		{

			if($varNewPassword  != $varConfirmPassword)

			{

			   $varErrorMessage = "New Password and Confirm New Password must be same.<br />";

			   $errorMsg .= $varErrorMessage;

			}

		}	

		if($errorMsg) 

		{ 

			$_SESSION["arrChangePassword"] = $argArrPOST;

			$this->objCore->setErrorMsg($errorMsg);				

			return false;		

		}

		else

		{

			$varUserID = $argArrPOST['AdminID'];	

			$varAdminClmn = 'PkUserId';

						

			$varWhereCondition = "1 AND PkUserID ='".$varUserID."' AND UserPassword = '".$varOldPassword."'";

			

			$varResultRows = $this->getNumRows(TABLE_ADMIN, $varAdminClmn, $varWhereCondition);

			

			if($varResultRows > 0)

			{		

				//check for valid password

			 	if(!preg_match("/^[a-zA-Z0-9\!\-\_\#\@]+$/u", $varNewPassword))

			    {

					$_SESSION["arrChangePassword"] = $argArrPOST;

					$this->objCore->setErrorMsg(USERS_SETTING_PAGE_PASSWORD_CHECK);

					return false;

			 	}

			    else

			    {

					 //end check for valid password

					$arrColumns = array('UserPassword'=> $varNewPassword);

					$varWhere = "PkUserId ='".$varUserID."'";

					$_SESSION['sessUserPassword'] = $varNewPassword;

					$varAffectedRows = $this->update(TABLE_ADMIN, $arrColumns, $varWhere);

						

					$this->sendChangePassMailToUser($argArrPOST);

					

					$this->objCore->setSuccessMsg(USERS_CHANGE_PASSWORD_MSG);

					return true;

				}

			}

			else

			{				

				$this->objCore->setErrorMsg(USERS_CHANGE_PASSWORD_ERR);

				return false;

			}

		}

	}

	

	function changeUserEmail($argArrPOST)

	{

		$this->objValid->check_4html = true;

		$_SESSION["arrPost"] = array();			

		

		$this->objValid->add_text_field('Admin E-mail', strip_tags($argArrPOST['frmAdminEmail']), 'email', 'y',100);

    	

		if(!($this->objValid->validation())) 

		{

			 $errorMsg = $this->objValid->create_msg();

			 $_SESSION['sessForgotEmail'] = $argArrPOST; #*

		     $this->objCore->setErrorMsg($errorMsg);				

			 return false;

			

		}

		else

		{

		  	$arrColumns = array('UserEmail'=>$argArrPOST['frmAdminEmail']);

			

			$varWhere = "PkUserId = '".$argArrPOST['AdminID']."'"; 

			

			$this->update(TABLE_ADMIN, $arrColumns, $varWhere);

			

			$this->objCore->setSuccessMsg(USERS_EMAIL_CHANGE_MSG);				

			return true;

		}  

	}

	

	function sendChangePassMailToUser($argArrPOST)

	{

		$varPath = "<img src = ".SITE_ROOT_URL.'admin/images/logo.png'.">"; 

		$varAdminUserPass = $argArrPOST['frmAdminNewPassword'];			

		$varWhere = "AND UserName = '".$_SESSION['sessErpAdminUserName']."' ";

		

		$arrAdminInfo = $this->getUserInfo($varWhere);	

		$varAdminUserName = $arrAdminInfo[0]['UserName'];					

		$varToAdmin = $arrAdminInfo[0]['UserEmail'];	

		

		$varFrom = SITE_NAME.'<'.$varToAdmin.'>';			

		$varSiteName = SITE_NAME;			

		$varWhereTemplate = ' EmailTemplateTitle = \'Send Change Password\' AND EmailTemplateStatus = \'Active\' ';

		$arrMailTemplate = $this->objEmailTemplate->getTemplateInfo($varWhereTemplate);

		$varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

		$varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

		

		$varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}');

		$varKeywordValues = array($varPath, $varSiteName, $varAdminUserName, $varAdminUserPass);

		$varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

		$varSubject = str_replace('{SITE_NAME}', $varSiteName, $varSubject);

		

		$this->objCore->sendMail($varToAdmin, $varFrom, $varSubject, $varOutPutValues);

	}

	

	

	function getUserEmail($argVarWhereCon = '') 

	{

		$arrClms = array('PkUserId', 'UserName', 'UserPassword', 'UserEmail',);

		$varWhere = ' 1 '.$argVarWhereCon;

		$arrUserRecords = $this->select(TABLE_ADMIN, $arrClms, $varWhere);

		return $arrUserRecords;

	}

	

	function resetPassword($arrPostData) {

		

     if($arrPostData['fgtPwdStatusCode']) {

		 

	    $_SESSION['fgtPwdCode'] = $arrPostData['fgtPwdStatusCode'];

	 }

	 	 

	 

	 if($_SESSION['fgtPwdCode']) 

	 {

		 

		$varReturnValue = $this->getResetPasswordValidation($arrPostData);

		if(!$varReturnValue)

		{

			return false;

		}

		

		if($arrPostData['frmNewPassword'] == $arrPostData['frmConfirmNewPassword'])

		{

		   $arrcols = 'PkUserId';

		   $where = '1 AND UserForgotPWCode=\''. $_SESSION['fgtPwdCode'].'\'';

		

		   $result = $this->isExists($where,$arrcols);

		   

			if($result!= 0)

			{

				$arrCols = array('UserPassword'=>$arrPostData['frmNewPassword']);

				$where = '1 AND UserForgotPWCode=\''.$_SESSION['fgtPwdCode'].'\'';

				$detail = $this->update(TABLE_ADMIN,$arrCols,$where);

				if($detail) {

					$this->objCore->setSuccessMsg(USERS_PASSWORD_RESET_SUCC);

					 $_SESSION['fgtPwdCode'] = '';				

					return true;

			 } } 

		       else {

			     $this->objCore->setErrorMsg(USERS_NOT_EXISTS);				

			     return false;

		      }

	      }      else {

		       $this->objCore->setErrorMsg(ADMIN_PASS_NEW_PASS);				

			     return false;

	     }

		} 

		 else {

			 $this->objCore->setErrorMsg(USERS_NOT_EXISTS);				

			  return false;

		      } 

}

	

	function getResetPasswordValidation($argArrPOST)

	{

	  	$this->objValid->check_4html = true;

		

		$this->objValid->add_text_field('New Password', strip_tags($argArrPOST['frmNewPassword']), 'text', 'y',30);

    	$this->objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST['frmConfirmNewPassword']), 'text', 'y',20);

	  	if(!($this->objValid->validation())) 

		{

			 $errorMsg = $this->objValid->create_msg();

			 $this->objCore->setErrorMsg($errorMsg);				

			 return false;	

		} 

	   	else

		{

		   return true;

		}  

	}	

	

	function isExists($where,$arrCols) {

		

		$result = $this->getNumRows(TABLE_ADMIN,$arrCols,$where);

		

		if($result) {

			

			return $result;

		} 

	}

	

	function doAdminLogout()

	{	

		if($_SESSION['sessErpUserDetails']){

			unset($_SESSION['sessErpAdminDetails']);

			unset($_SESSION['pageRecordSize']);

			unset($_SESSION['sessErpAdminUserName']);

			unset($_SESSION['isAdmin']);

		}else{

			unset($_SESSION);

			session_destroy();

		}

	}

	

		

 }//end of class

?>