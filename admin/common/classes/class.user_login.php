<?php
class UserLogin extends Database {

    private $objCore;
    private $objValid;
    private $objEmailTemplate;
    private $objGeneral;

    function __construct() {
        parent::__construct();
        $this->objCore = Factory::getInstanceOf('Core');
        $this->objValid = Factory::getInstanceOf('Validate_fields');
        $this->objEmailTemplate = Factory::getInstanceOf('EmailTemplate');
        $this->objGeneral = Factory::getInstanceOf('General');
    }

    function doUserLogin($argArrPOST) {

        if (isset($argArrPOST)) {
            //server side validation
            $varReturnValue = $this->getLoginValidation($argArrPOST);
            if (!$varReturnValue) {
                return false;
            }

            /* -start-login verification - */
            $varUserName = $argArrPOST ['frmAdminUserName'];
            $varUserPassword = $argArrPOST ['frmAdminPassword'];
             $varWhereCondition = " AND CompanyEmployeeUserName = binary '" . $varUserName . "' AND CompanyEmployeePassword = '" . $varUserPassword . "' AND FkCompanyID=" . $_SESSION ['sessErpCompanyId'];
            $arrUserDeatils = $this->getUserInfo($varWhereCondition);

            if ($arrUserDeatils != NULL) {
                if ($arrUserDeatils [0] ['CompanyEmployeeUserStatus'] == 'Active') {
                    $_SESSION ['sessErpUserDetails'] = $arrUserDeatils;
                    $_SESSION ['sessErpUserName'] = $varUserName;
                    $_SESSION['pageRecordSize'] = $arrUserDeatils[0]['UserPageRecordSize'];
                    $_SESSION ['sessErpEmployeeName'] = $arrUserDeatils[0]['CompanyEmployeeFirstName'] . ' ' . $arrUserDeatils[0]['CompanyEmployeeLastName'];
                    $_SESSION ['sessErpEmployeeId'] = $arrUserDeatils[0]['PkCompanyEmployeeID'];

                    /* -find permitted modules- */
                    $arrayModuleCol = array('PkCompanyModuleID', 'CompanyModuleName', 'CompanyModuleStatus');
                    $strCompWhereCond = '1 AND CompanyModulePermissionStatus=\'Active\' AND  FkCompanyID=' . $_SESSION ['sessErpCompanyId'];
                    $tableName = TABLE_COMPANY_MODULES . ' RIGHT JOIN ' . TABLE_COMPANY_MODULE_PERMISSIONS . ' ON (PkCompanyModuleID=FkCompanyModuleID)';
                    $arrayModuleResult = $this->select($tableName, $arrayModuleCol, $strCompWhereCond);
                    if ($arrayModuleResult) {
                        $arrayMFResult = $this->getFormatedModuleData($arrayModuleResult);
                        $_SESSION ['sessArrPermittedModules'] = $arrayMFResult;
                    }
                    /* -[end]find permitted modules- */

                    /* -update entry for last login data - */
                    $varIpAddress = $_SERVER ['REMOTE_ADDR'];
                    $varRandom = rand(0, 1000);
                    $arrColumns = array('CompanyEmployeeLastLoginDate' => date("Y-m-d H:i:s"), 'CompanyEmployeeLastLoginIP' => $varIpAddress, 'CompanyEmployeeForgotPWCode' => $varRandom);
                    $varWhereCondition = "PkCompanyEmployeeID = '" . $_SESSION ['sessErpUserDetails'] [0] ['PkCompanyEmployeeID'] . "'";
                    $this->update(TABLE_COMPANY_EMPLOYEE, $arrColumns, $varWhereCondition); #end-insert entry for last login data
                    /* -[end]update entry for last login data - */

                    return true; // after successfull login return true to redirect to dashboard
                } else {
                    $this->objCore->setErrorMsg(ERR_USER_INACTIVE);
                    return false;
                }
            } else {
                //else return false to redirect to login form page
                $this->objCore->setErrorMsg(ERR_USER_LOGIN);
                return false;
            }
        } else {
            $this->objCore->setErrorMsg(ERR_USER_LOGIN);
            return false;
        }
    }

    function getLoginValidation($argArrPOST) {
        $this->objValid->check_4html = true;

        $this->objValid->add_text_field('User Name', strip_tags($argArrPOST ['frmAdminUserName']), 'text', 'y', 30);
        $this->objValid->add_text_field('Password', strip_tags($argArrPOST ['frmAdminPassword']), 'text', 'y', 20);
        if (!($this->objValid->validation())) {
            $errorMsg = $this->objValid->create_msg();
            $this->objCore->setErrorMsg($errorMsg);
            return false;
        } else {
            return true;
        }
    }

    function getUserInfo($argWhere) {
         $arrEmpCol = array('PkCompanyEmployeeID', 'FkCompanyID', 'CompanyEmployeeCode', 'CompanyEmployeeUserName', 'CompanyEmployeePassword',
            'FkCompanyEmployeeUserRoleID', 'CompanyEmployeeFirstName', 'CompanyEmployeeLastName',
            'CompanyEmployeePersonalEmail', 'CompanyEmployeeWorkEmail', 'FkCompanyStructureID', 'FkCompanyEmployeeDesignationID',
            'CompanyEmployeeStatus', 'CompanyEmployeeSignupDate', 'CompanyEmployeeLastLoginDate', 'CompanyEmployeeForgotPWCode', 'CompanyEmployeeLastLoginIP',
            'CompanyEmployeeUserStatus', 'UserPageRecordSize');
         $strEmpWhereCond = '1 ' . $argWhere;
        $arrUserResults = $this->select(TABLE_COMPANY_EMPLOYEE, $arrEmpCol, $strEmpWhereCond);
        
        return $arrUserResults;
    }

    function changePageRecordSize($arrPostData) {
        $arrClms = array('UserPageRecordSize' => $arrPostData ['frmPageRecordSize']);
        $varWhere = '1 AND PkCompanyEmployeeID=' . $arrPostData ['employeeId'] . ' AND FkCompanyID=' . $_SESSION['sessErpCompanyId'];
        $status = $this->update(TABLE_COMPANY_EMPLOYEE, $arrClms, $varWhere);
        if ($status) {
            $this->objCore->setSuccessMsg('<p>Page record size updated successfully.<br/>Please logout and then login again to see effect.</p>');
            return $arrPostData ['frmPageRecordSize'];
        } else {
            return false;
        }
    }

    function getFormatedModuleData($argResult) {
        $arrFormatedResult = array();
        for ($i = 0; $i < count($argResult); $i++) {
            $arrFormatedResult[$argResult[$i]['PkCompanyModuleID']] = $argResult[$i]['CompanyModuleName'];
        }
        return $arrFormatedResult;
    }

    function forgotPasswordMail($argArrPOST) {

        $objValid->check_4html = true;

        $_SESSION ['sessForgotValues'] = array();

        $this->objValid->add_text_field('Username (E-mail) ', strip_tags($argArrPOST ['frmUserName']), 'email', 'y', 255);
        $this->objValid->add_text_field('Verification Code', strip_tags($argArrPOST ['frmSecurityCode']), 'text', 'y', 255);

        if (!($this->objValid->validation())) {
            $errorMsg = $this->objValid->create_msg();
            $_SESSION ['sessForgotValues'] = $argArrPOST; #*
            $this->objCore->setErrorMsg($errorMsg);
            return false;
        }

        if (($_SESSION ['security_code'] == $argArrPOST ['frmSecurityCode']) && (!empty($_SESSION ['security_code']))) {
            $varWhereCond = "AND CompanyEmployeePersonalEmail  ='" . $argArrPOST ['frmUserName'] . "' AND FkCompanyID=" . $_SESSION ['sessErpCompanyId'];
            $userInfo = $this->getUserInfo($varWhereCond);

            if ($userInfo != NULL) {

                $varUserID = $userInfo ['0'] ['PkCompanyEmployeeID'];

                //memberdata contain member username
                $varMemberData = trim(strip_tags($argArrPOST ['frmUserName']));
                $varForgotPasswordCode = $this->objGeneral->getValidRandomKey(TABLE_COMPANY_EMPLOYEE, array('PkCompanyEmployeeID'), 'CompanyEmployeeForgotPWCode', '25');
                $varForgotPasswordLink = '<a href="' . SITE_ROOT_URL . '/reset_password.php?mid=' . $varUserID . '&code=' . $varForgotPasswordCode . '">' . SITE_ROOT_URL . '/reset_password.php?mid=' . $varUserID . '&code=' . $varForgotPasswordCode . '</a>';

                $arrColumns = array('CompanyEmployeeUserStatus' => 'Active', 'CompanyEmployeeForgotPWCode' => $varForgotPasswordCode);
                $varWhereCondition = 'PkCompanyEmployeeID = \'' . $varUserID . '\'';
                $this->update(TABLE_COMPANY_EMPLOYEE, $arrColumns, $varWhereCondition);

                $vaUserEmail = $userInfo [0] ['CompanyEmployeePersonalEmail'];
                $varToUser = $vaUserEmail;
                $varFromUser = SITE_NAME . "." . $vaUserEmail;
                $varSiteName = SITE_NAME;
                $varWhereTemplate = ' EmailTemplateTitle= \'Admin forgot password\' AND EmailTemplateStatus = \'Active\' ';
                $arrMailTemplate = $this->objEmailTemplate->getTemplateInfo($varWhereTemplate);
                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate [0] ['EmailTemplateDescription']));
                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate [0] ['EmailTemplateSubject']));
                /*                 * ***** */
                $varSubject = str_replace('{PROJECT_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate ['0'] ['EmailTemplateSubject'])));
                $varKeyword = array('{IMAGE_PATH}', '{MEMBER}', '{PROJECT_NAME}', '{USER_DATA}', '{FORGOT_PWD_LINK}', '{SITE_NAME}');
                $varKeywordValues = array($varPathImage, 'Admin', SITE_NAME, $varMemberData, $varForgotPasswordLink, SITE_NAME);
                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
                // Calling mail function
                //echo $varToUser . $varFromUser . $varSubject . $varOutPutValues;die;
                $this->objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                $_SESSION ['sessForgotValues'] = '';
                $this->objCore->setSuccessMsg(MSG_USER_FORGOT_PASSWORD_CONFIRM);
                return true;
            } else {
                $_SESSION ['sessForgotValues'] = $argArrPOST;
                $this->objCore->setErrorMsg(MSG_EMAIL_NOT_EXIST);
                return true;
            }
        } else {
            $_SESSION ['sessForgotValues'] = $argArrPOST;
            $this->objCore->setErrorMsg(MSG_INVALID_SECURITY_CODE);
            return false;
        }
    }

    function changeUserPassword($argArrPOST) {
        $this->objValid->check_4html = true;
        $_SESSION ["arrChangePassword"] = array();

        $varOldPassword = $argArrPOST ['frmAdminOldPassword'];
        $varNewPassword = $argArrPOST ['frmAdminNewPassword'];
        $varConfirmPassword = $argArrPOST ['frmAdminConfirmPassword'];

        //*** server side validation will start from here .
        $this->objValid->add_text_field('Current Password', strip_tags($argArrPOST ['frmAdminOldPassword']), 'text', 'y', 100);
        $this->objValid->add_text_field('New Password', strip_tags($argArrPOST ['frmAdminNewPassword']), 'text', 'y', 100);
        $this->objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST ['frmAdminConfirmPassword']), 'text', 'y', 100);

        if (!($this->objValid->validation())) {
            $errorMsg = $this->objValid->create_msg();
        }

        if ($varNewPassword != '' && $varConfirmPassword != '') {
            if ($varNewPassword != $varConfirmPassword) {
                $varErrorMessage = "New Password and Confirm New Password must be same.<br />";
                $errorMsg .= $varErrorMessage;
            }
        }
        if ($errorMsg) {
            $_SESSION ["arrChangePassword"] = $argArrPOST;
            $this->objCore->setErrorMsg($errorMsg);
            return false;
        } else {

            $varUserID = $argArrPOST ['AdminID'];
            $varUserCols = 'PkCompanyEmployeeID';
            $varWhereCondition = "1 AND PkCompanyEmployeeID ='" . $varUserID . "' AND CompanyEmployeePassword = '" . $varOldPassword . "'";
            $varResultRows = $this->getNumRows(TABLE_COMPANY_EMPLOYEE, $varUserCols, $varWhereCondition);

            if ($varResultRows > 0) {
                //check for valid password
                if (!preg_match("/^[a-zA-Z0-9\!\-\_\#\@]+$/u", $varNewPassword)) {
                    $_SESSION ["arrChangePassword"] = $argArrPOST;
                    $this->objCore->setErrorMsg(USERS_SETTING_PAGE_PASSWORD_CHECK);
                    return false;
                } else {
                    //end check for valid password
                    $arrColumns = array('CompanyEmployeePassword' => $varNewPassword);
                    $varWhere = "PkCompanyEmployeeID ='" . $varUserID . "'";
                    $_SESSION ['sessUserPassword'] = $varNewPassword;
                    $varAffectedRows = $this->update(TABLE_COMPANY_EMPLOYEE, $arrColumns, $varWhere);

                    $this->sendChangePassMailToUser($argArrPOST);

                    $this->objCore->setSuccessMsg(MSG_USERS_CHANGE_PASSWORD);
                    return true;
                }
            } else {
                $this->objCore->setErrorMsg(ERR_USERS_CHANGE_PASSWORD);
                return false;
            }
        }
    }

    function changeUserEmail($argArrPOST) {
        $this->objValid->check_4html = true;
        $_SESSION ["arrPost"] = array();

        $this->objValid->add_text_field('User E-mail', strip_tags($argArrPOST ['frmAdminEmail']), 'email', 'y', 100);

        if (!($this->objValid->validation())) {
            $errorMsg = $this->objValid->create_msg();
            $_SESSION ['sessForgotEmail'] = $argArrPOST;
            $this->objCore->setErrorMsg($errorMsg);
            return false;
        } else {
            $arrColumns = array('CompanyEmployeePersonalEmail' => $argArrPOST ['frmAdminEmail']);

            $varWhere = "PkCompanyEmployeeID = '" . $argArrPOST ['AdminID'] . "' AND FkCompanyID=" . $_SESSION['sessErpUserId'];

            $this->update(TABLE_COMPANY_EMPLOYEE, $arrColumns, $varWhere);

            $this->objCore->setSuccessMsg(MSG_USERS_EMAIL_CHANGE);
            return true;
        }
    }

    function sendChangePassMailToUser($argArrPOST) {
        $varPath = "<img src = " . SITE_ROOT_URL . 'common/images/logo.png' . ">";
        $varAdminUserPass = $argArrPOST ['frmAdminNewPassword'];
        $varWhere = "AND CompanyEmployeeUserName = '" . $_SESSION ['sessErpUserName'] . "' AND FkCompanyID=" . $_SESSION ['sessErpCompanyId'];

        $arrUserInfo = $this->getUserInfo($varWhere);
        $varUserName = $arrUserInfo [0] ['CompanyEmployeeUserName'];
        $varTo = $arrUserInfo [0] ['CompanyEmployeePersonalEmail'];

        $varFrom = SITE_NAME . '<' . $varTo . '>';
        $varSiteName = SITE_NAME;
        $varWhereTemplate = ' EmailTemplateTitle = \'Send Change Password\' AND EmailTemplateStatus = \'Active\' ';
        $arrMailTemplate = $this->objEmailTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate [0] ['EmailTemplateDescription']));
        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate [0] ['EmailTemplateSubject']));

        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}');
        $varKeywordValues = array($varPath, $varSiteName, $varUserName, $varAdminUserPass);
        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
        $varSubject = str_replace('{SITE_NAME}', $varSiteName, $varSubject);

        $this->objCore->sendMail($varTo, $varFrom, $varSubject, $varOutPutValues);
    }

    function getUserEmail($argVarWhereCon = '') {
        $arrClms = array('PkCompanyEmployeeID', 'CompanyEmployeeUserName', 'CompanyEmployeePassword', 'CompanyEmployeePersonalEmail');
        $varWhere = ' 1 ' . $argVarWhereCon;
        $arrUserRecords = $this->select(TABLE_COMPANY_EMPLOYEE, $arrClms, $varWhere);
        return $arrUserRecords;
    }

    function resetPassword($arrPostData) {

        if ($arrPostData ['fgtPwdStatusCode']) {
            $_SESSION ['fgtPwdCode'] = $arrPostData ['fgtPwdStatusCode'];
        }
        if ($_SESSION ['fgtPwdCode']) {

            $varReturnValue = $this->getResetPasswordValidation($arrPostData);
            if (!$varReturnValue) {
                return false;
            }

            if ($arrPostData ['frmNewPassword'] == $arrPostData ['frmConfirmNewPassword']) {
                $arrcols = 'FkCompanyID';
                $where = '1 AND CompanyEmployeeForgotPWCode=\'' . $_SESSION ['fgtPwdCode'] . '\'';

                $result = $this->isExists($where, $arrcols);

                if ($result != 0) {
                    $arrCols = array('CompanyEmployeePassword' => $arrPostData ['frmNewPassword']);
                    $where = '1 AND CompanyEmployeeForgotPWCode=\'' . $_SESSION ['fgtPwdCode'] . '\' AND FkCompanyID=' . $_SESSION['sessErpCompanyId'];
                    $detail = $this->update(TABLE_COMPANY_EMPLOYEE, $arrCols, $where);
                    if ($detail) {
                        $this->objCore->setSuccessMsg(SUCC_USERS_PASSWORD_RESET);
                        unset($_SESSION ['fgtPwdCode']);
                        return true;
                    }
                } else {
                    $this->objCore->setErrorMsg(ERR_USERS_NOT_EXISTS);
                    return false;
                }
            } else {
                $this->objCore->setErrorMsg(ERR_USER_CONFIRM_PASS);
                return false;
            }
        } else {
            $this->objCore->setErrorMsg(ERR_USERS_NOT_EXISTS);
            return false;
        }
    }

    function getResetPasswordValidation($argArrPOST) {
        $this->objValid->check_4html = true;

        $this->objValid->add_text_field('New Password', strip_tags($argArrPOST ['frmNewPassword']), 'text', 'y', 30);
        $this->objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST ['frmConfirmNewPassword']), 'text', 'y', 20);
        if (!($this->objValid->validation())) {
            $errorMsg = $this->objValid->create_msg();
            $this->objCore->setErrorMsg($errorMsg);
            return false;
        } else {
            return true;
        }
    }

    function isExists($where, $arrCols) {
        $result = $this->getNumRows(TABLE_COMPANY_EMPLOYEE, $arrCols, $where);
        if ($result) {
            return $result;
        }
    }

    function doUserLogout() {

        if ($_SESSION['sessErpAdminDetails']) {
            unset($_SESSION['sessErpUserDetails']);
            unset($_SESSION['sessErpUserName']);
            unset($_SESSION['pageRecordSize']);
            unset($_SESSION['sessErpEmployeeName']);
            unset($_SESSION['sessErpEmployeeId']);
        } else {
            unset($_SESSION);
            session_destroy();
        }
    }

    function isValidUser() {
        if ($_SESSION ['sessErpUserDetails'] == '') {
            unset($_SESSION);
            header('location:' . SITE_ROOT_URL . '/index.php');
            die();
        }
    }

}

//end of class
?>