<?php
class EmailTemplate extends Database
{
	function __construct() {
	   	parent::__construct();
	}
	
	function getTemplateInfo($argWhere) 
	{
		$arrClms = array('pkEmailTemplateID', 'EmailTemplateTitle', 'EmailTemplateSubject', 'EmailTemplateDescription', 'EmailTemplateStatus', 'EmailTemplateDateAdded', 'EmailTemplateDateModified', 'EmailTemplateModifiedBy');
		$varWhere = $argWhere;
		$arrResults = $this->select(TABLE_EMAIL_TEMPLATES, $arrClms, $varWhere);
		return $arrResults;
	}
	
	function updateEmailTemplates($post, $where = '') {
		if($post) {
			//print_r($post);die;
			$varWhere  = ' pkEmailTemplateID=\''.$post[pkEmailTemplateID].'\'';
			$arrColumn = array(EmailTemplateSubject => $post[EmailTemplateSubject] , EmailTemplateDescription=> $post[EmailTemplateDescription]);
			$this->update(TABLE_EMAIL_TEMPLATES, $arrColumn, $varWhere);
			return true;
		}	else {
			return false;
		}
	}
}
?>