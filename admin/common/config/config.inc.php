<?php error_reporting(0);
session_start();
ini_set('display_errors', "0");//Set display error true.
ini_set('error_reporting', E_ALL ^ E_NOTICE);//Report all error except notice
ini_set('session.use_only_cookies', 1);// Do not allow php_sess_id to be passed in the querystring and it's use for google search

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
//Start new sesstion

// Base url
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$baseurl = "http://" . $host . $path . "/";
$securebaseurl = "https://" . $host . $path . "/";
//Database configuration settings for local and server mode and define some constant
if($_SERVER['HTTP_HOST'] == "localhost"){
    $arrConfig['dbHost'] = 'localhost';
	$arrConfig['dbName'] = 'funeral';
    $arrConfig['dbUser'] = 'root';
    $arrConfig['dbPass'] = '';
	$arrConfig['siteRootURL'] = 'http://'.$_SERVER['HTTP_HOST'].'/funeral/';
	$arrConfig['secureSiteRootURL'] = 'https://'.$_SERVER['HTTP_HOST'].'/funeral/';
	define('LOCAL_MODE', true);
	define('ROOT_DIRECTORY', 'funeral');
} else {
	$arrConfig['dbHost'] = 'localhost'; 
 	$arrConfig['dbName'] = 'kaiserfu_funeral';
    $arrConfig['dbUser'] = 'kaiserfu_funeral';
    $arrConfig['dbPass'] = '1n1#C[9J2=Qi';
  	$arrConfig['siteRootURL'] = $baseurl;
 	$arrConfig['secureSiteRootURL'] = $securebaseurl; 
  	define('LOCAL_MODE', false);
  	define('ROOT_DIRECTORY', 'funeral');
}

$varSiteFsPath = dirname(__FILE__);//Get source root path 
$varSiteFsPath = str_replace('\\' ,'/',$varSiteFsPath);
$arrConfig['sourceRoot'] = str_replace('/common/config' ,'/',$varSiteFsPath);

//defining source root and site root url
define('SOURCE_ROOT',$arrConfig['sourceRoot']);
define('SITE_ROOT_URL', $arrConfig['siteRootURL']);

define('SECURE_SITE_ROOT_URL', $arrConfig['secureSiteRootURL']);
define('SECURE_URL_HOST','https://'.$_SERVER['HTTP_HOST'].'/');
define('SITE_ROOT_URL_HOST','http://'.$_SERVER['HTTP_HOST'].'/');

define('DB_HOST',$arrConfig['dbHost']);
define('DB_NAME', $arrConfig['dbName']);
define('DB_USER', $arrConfig['dbUser']);
define('DB_PASS',$arrConfig['dbPass']);

//Include common configration files
require_once SOURCE_ROOT.'common/config/page_constants.inc.php';
require_once SOURCE_ROOT.'common/config/table_constants.inc.php';
require_once SOURCE_ROOT.'common/config/message_constants.inc.php';
	
require_once SOURCE_ROOT.'common/classes/class.factory.php';	
require_once SOURCE_ROOT.'common/classes/class.database.php';
require_once SOURCE_ROOT.'common/classes/class.core.php';
require_once SOURCE_ROOT.'common/classes/class.general.php';
require_once SOURCE_ROOT.'common/classes/class.access_control.php';
require_once SOURCE_ROOT.'common/classes/class.upload.php';
require_once SOURCE_ROOT.'common/classes/class.email_template.php';
require_once SOURCE_ROOT.'components/class.validation.inc.php';
require_once SOURCE_ROOT.'common/classes/class.sort.php';

require_once SOURCE_ROOT.'common/functions/common_functions.php';	
require_once SOURCE_ROOT.'common/functions/string_functions.php';
require_once SOURCE_ROOT.'common/functions/date_functions.php';
/*-gloabal objects-*/
$objCore=Factory::getInstanceOf('Core');
$objGeneral=Factory::getInstanceOf('General');
$objAccessControl=Factory::getInstanceOf('AccessControl');
/*-end[gloabal objects]-*/

/*-applying access control-*/
$arrPagesExcudedInUserPermission=array(
										'login_action.php',
										'logout.php',
										'about.php',
										'index.php',
										'contact-us.php',
										'forgot_password.php',
										'forgot_password_action.php',
										'reset_password.php',
										'reset_password_action.php');

$arrPagesExcludedInModulePermission=array(
										'login_action.php',
										'logout.php',
										'forgot_password.php',
										'welcome.php',
										'forgot_password_action.php',
										'reset_password.php',
										'reset_password_action.php',
										'forgot_password_mail.php',
										'registration_mail.php',
										'settings_action.php',
										'settings_frm.php');

$varFileName = $_SERVER['SCRIPT_NAME'];
$arrFolders=explode("/",$varFileName);
//echo '<pre>';
//print_r($arrFolders);

if(!@in_array('public', $arrFolders)){

	if(@in_array('admin', $arrFolders)){
		
		/*-applying access control for admin-*/
		AccessControl::isValidAdmin(ROOT_DIRECTORY,$arrPagesExcudedInUserPermission);/*-check admin login status-*/
		/*-[end]applying access control for admin-*/
	}
	else{
		//echo '@@@@';
		//die;
		/*-applying access control for company-*/
		//echo '@@@@@@';
		//die();
		//AccessControl::isValidUser(ROOT_DIRECTORY,$arrPagesExcudedInUserPermission);/*-check user login status-*/
		/*-Load company details dynamically-*/
		//$objAccessControl->loadCompany(DEFAULT_COMPANY_DOMAIN);
		/*-end[Load company details dynamically]-*/

		/*-set time zone dynamically-*/
		/*if($_SESSION['sessErpCompanyId']){
			if(!$_SESSION['time_zone']){
				$timeZone=$objGeneral->getRecord('hr_company',array('CompanyTimeZone'),'1 AND PkCompanyId='.$_SESSION['sessErpCompanyId']);
				$_SESSION['time_zone']=$timeZone[0]['CompanyTimeZone'];
			}
			date_default_timezone_set($_SESSION['time_zone']);//set time zone
		}*/
		/*-end[set time zone dynamically]-*/
		
		/*$permissionVariables=$objAccessControl->getModulePermissions($arrPagesExcludedInModulePermission);
		if($permissionVariables){
			extract($permissionVariables);
			if(!$permissions){
				if($isErrorMsgTrue){
					$_SESSION['sessAccessDeniedErr']='Access Denied!';
				}
				if($isPageRedirect){
					sendRedirect(SITE_ROOT_URL.'welcome.php');
				}
			}
		}*/
		/*-[end]applying access control for company-*/
	}
	/*-[end]applying access control-*/
}
?>