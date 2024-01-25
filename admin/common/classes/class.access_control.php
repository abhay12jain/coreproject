<?php

class AccessControl extends Database{



	public function getModulePermissions($arrPagesExcludedInModulePermission){            

		/*-check user module permission-*/

		if($_SESSION ['sessArrPermittedModules']){

			$arrPermittedModules=$_SESSION ['sessArrPermittedModules'];

			$arrModuleNames=array_values($arrPermittedModules);

                        

			AccessControl::checkModulesPermission(ROOT_DIRECTORY,$arrModuleNames,$arrPagesExcludedInModulePermission);

		}

		/*-[end]check user module permission-*/

		

                

		/*-check user permissions-*/

		if($_SESSION['sessErpCompanyId']){

			if($_SESSION['sessErpUserDetails'][0]['FkCompanyEmployeeUserRoleID']){/*-find user permissions-*/

				$currentFileName=end(explode('/',$_SERVER['SCRIPT_NAME']));

				if(!@in_array($currentFileName, $arrPagesExcludedInModulePermission)){

					$arrPermissions=$this->getUserRolePermissions($_SESSION['sessErpUserDetails'][0]['FkCompanyEmployeeUserRoleID'],$currentFileName);

					$arrPermissionVariables=array('isPageRedirect'=>$arrPermissions['page_redirection_status'],'isErrorMsgTrue'=>$arrPermissions['page_error_msg_status'],'permissions'=>$arrPermissions['permissions']);

					return $arrPermissionVariables;/*-after extracting this array it becomes permission variables-*/

						

				}else{

					return false;

				}

			}else{

				return false;

			}

		}else{

			return false;

		}

				

		/*-end[check user permissions]-*/

	}



	

	static function isValidUser($rootFolder, $arrExcludedPageNames=array()) {

		

		$varFileName = $_SERVER['SCRIPT_NAME'];

		$arrFileName = explode("/", $varFileName);

		$currentArrayLength = count($arrFileName);

		

		$isValidDirectory = array_search($rootFolder, $arrFileName);

		$isExcludedPage=@in_array($arrFileName[($currentArrayLength - 1)], $arrExcludedPageNames);

		if($isValidDirectory!='' && $isValidDirectory>0 &&  (!$isExcludedPage) ){

			if (!$_SESSION ['sessErpUserDetails']) {

				header ( 'location:' . SITE_ROOT_URL . 'index.php' );

				die ();

			}

		}

	}

	

	static function isValidAdmin($rootFolder, $arrExcludedPageNames=array()) {

	

		$varFileName = $_SERVER['SCRIPT_NAME'];

		 $arrFileName = explode("/", $varFileName);
		 //print_r($arrFileName);

		$currentArrayLength = count($arrFileName);

		 $isValidDirectory = array_search($rootFolder, $arrFileName);
        
        $isExcludedPage=@in_array($arrFileName[($currentArrayLength - 1)], $arrExcludedPageNames);
        

		if($isValidDirectory!='' && $isValidDirectory>0 &&  (!$isExcludedPage) ){

			if (!$_SESSION ['sessErpAdminDetails']) {

				header ( 'location:' . SITE_ROOT_URL . 'admin/index.php' );

				die ();

			}

		}

	}

	

 	static function checkModulesPermission($rootFolder,$arrPermittedModuleName,$arrExcludedPageNames=array()) {

		

		$varFileName = $_SERVER['SCRIPT_NAME'];

		$arrFileName = explode("/", $varFileName);

		$currentArrayLength = count($arrFileName);	

		$isValidDirectory = array_search($rootFolder, $arrFileName);

			

		$isExcludedPage=@in_array($arrFileName[($currentArrayLength - 1)], $arrExcludedPageNames);

		if($isValidDirectory!='' && $isValidDirectory>0 &&  (!$isExcludedPage) ){

			$isValid=false;

			$perCount=count($arrPermittedModuleName);

			for($i=0;$i<$perCount;$i++){

				if(@in_array(strtolower($arrPermittedModuleName[$i]),$arrFileName)){

					$isValid=true;

					break;

				}

			}

			

			$url='location:'.SITE_ROOT_URL.'index.php';

			if($_SESSION['isAdmin']){

					$url='location:'.SITE_ROOT_URL.'admin/index.php';

			}



			if(!$isValid){

				unset($_SESSION);

				session_destroy();

				header ($url);die;

			}

		}

	}	

		

	function getModuleIdByModuleName($moduleName){

                

		$arrCols=array('FkCompanyModuleID','PageRedirectionStatus','PageErrorMsgStatus');

		$where='1 AND CompanyModuleFileName=\''.$moduleName.'\' AND CompanyModuleFileStatus=\'Active\'';

		$arrIds=$this->select(TABLE_COMPANY_MODULE_FILES,$arrCols,$where);

		if($arrIds){

			return $arrIds;

		}else{

			return false;

		}

	}

	

	function getUserRolePermissions($roleId,$fileName){

            

		$arrModuleIds=$this->getModuleIdByModuleName($fileName);

		$currentModuleId=$arrModuleIds[0]['FkCompanyModuleID'];

		$pageRedirectionStatus=$arrModuleIds[0]['PageRedirectionStatus'];

		$pageErrorMsgStatus=$arrModuleIds[0]['PageErrorMsgStatus'];

		

		$arrPermissions=array('page_redirection_status'=>$pageRedirectionStatus,'page_error_msg_status'=>$pageErrorMsgStatus);

		if($currentModuleId){

			$arrCols=array('CompanyEmployeeRolePermission');

			$where='1 AND FkCompanyID='.$_SESSION['sessErpCompanyId'].' AND FkCompanyEmployeeRoleID='.$roleId.' AND FkCompanyModuleID='.$currentModuleId;

			$permissions=$this->select(TABLE_COMPANY_EMPLOYEE_PERMISSION,$arrCols,$where);

			$permissionsValues=array();

			if($permissions){

				foreach($permissions as $perValue){

					$permissionsValues[]=$perValue['CompanyEmployeeRolePermission'];

				}

			}

			$arrPermissions['permissions']=$permissionsValues;

			return $arrPermissions;

		}else{

			return false;

		}

		

	}

	

	

	function loadCompany($companyDomainName){

		if(!$_SESSION ['sessErpCompanyId']){/*-start-finding company infprmation-*/

			$arrayCompCol = array ('PkCompanyID', 'CompanyName', 'CompanyDomainName' );

			$strCompWhereCond = '1 AND CompanyDomainName=\''.$companyDomainName.'\''; //it is for temp..

			$arrayCompResult = $this->select ( TABLE_COMPANY, $arrayCompCol, $strCompWhereCond );

			if ($arrayCompResult) {

				$_SESSION ['sessErpCompanyId'] = $arrayCompResult [0] ['PkCompanyID'];

				$_SESSION ['sessErpCompanyName'] = $arrayCompResult [0] ['CompanyName'];

				$_SESSION ['sessErpCompanyDomainName']=$arrayCompResult [0] ['CompanyDomainName'];

				

			}

		}/*-end[finding company infprmation]-*/

		

	}

	

	function isMenuRequired($roleId,$companyId,$arrFiles){

		$strFiles=implode(',', $arrFiles);

		$strFiles = "'".implode("','",explode(",",$strFiles))."'";

		$arrCols=array('mf.FkCompanyModuleID');

		$tableName=TABLE_COMPANY_EMPLOYEE_PERMISSION.' mep LEFT JOIN '.TABLE_COMPANY_MODULE_FILES.' mf ON(mep.FkCompanyModuleID = mf.FkCompanyModuleID)';

		$where='CompanyModuleFileName IN('.$strFiles.') AND FkCompanyEmployeeRoleID='.$roleId.' AND mep.FkCompanyID='.$companyId.' AND CompanyEmployeeRolePermission != \'none\' GROUP BY mf.FkCompanyModuleID';

		$arrResult = $this->select ( $tableName, $arrCols, $where );

//$_SESSION[query][] = $this->lastQuery();

		if ($arrResult) {

			return $arrResult[0]['FkCompanyModuleID'];

		}

	}

	 function getModulesByEmployeeRolesId($roleId){

		

	 	$arrCols=array('CompanyModuleName');

		$tableName=TABLE_COMPANY_MODULES.' cm INNER JOIN '.TABLE_COMPANY_EMPLOYEE_PERMISSION.' ep ON(cm.PkCompanyModuleID = ep.FkCompanyModuleID)';

		$where='1 AND FkCompanyEmployeeRoleID=\''.$roleId.'\' AND FkCompanyID='.$_SESSION ['sessErpCompanyId'];

		$arrIds=$this->select($tableName,$arrCols,$where);

		if($arrIds){

			return $arrIds;

		}else{

			return false;

		}

	 }

} 

?>