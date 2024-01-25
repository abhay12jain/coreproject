<?php

 /*-define constants for admin and clients(common) resorces-*/



define('CANDIDATE_RESUME_PATH',SOURCE_ROOT.'recruitment/recruitment_files/candidate_resume/');

define('CANDIDATE_RESUME_URL',SITE_ROOT_URL.'recruitment/recruitment_files/candidate_resume/');

define('CANDIDATE_FILE_LIST_PATH',SOURCE_ROOT.'recruitment/recruitment_files/candidate_excel_list/');

define('CANDIDATE_FILE_LIST_URL',SITE_ROOT_URL.'recruitment/recruitment_files/candidate_excel_list/');





define('EMPLOYEE_IMAGES_PATH',SOURCE_ROOT.'employee/employee_files/employee_images/');

define('EMPLOYEE_IMAGES_URL',SITE_ROOT_URL.'employee/employee_files/employee_images/');



define('EMPLOYEE_DOCUMENTS_PATH',SOURCE_ROOT.'employee/employee_files/employee_documents/');

define('EMPLOYEE_DOCUMENTS_URL',SITE_ROOT_URL.'employee/employee_files/employee_documents/');

define('EMPLOYEE_APPRAISAL_DOCUMENTS_PATH',SOURCE_ROOT.'employee/employee_files/employee_appraisal_documents/');

define('EMPLOYEE_APPRAISAL_DOCUMENTS_URL',SITE_ROOT_URL.'employee/employee_files/employee_appraisal_documents/');





/*-define constants for others-*/



/*-current file name*/

define('FILE_NAME',basename($_SERVER['PHP_SELF']));

/*-[end]current page name*/



/*-define site name-*/



define('SITE_NAME','Funeral');

define('MAX_UPLOAD_SIZE', 10485760);//1048576=1mb//define max upload image size 

define('PAGE_SIZE', 3);//Define site paging record limit



$pageRSize=$_SESSION['pageRecordSize'];

if($pageRSize==''){

	$pageRSize=10;

}



define('ADMIN_PAGE_RECORD_SIZE',$pageRSize);//Define admin paging record limit

define('SITE_RECORD_LIMIT',10);//Define admin paging record limit

define('ADMIN_EMAIL',$_SESSION['sessErpAdminDetails']['UserEmail']);//define admin email





if($_SESSION['limit'] == '') {

   define('PAGE_LIMIT',10);

} else {

	define('PAGE_LIMIT',$_SESSION['limit']);

}



/*-default company setting-*/

define('DEFAULT_COMPANY_DOMAIN','www.ipraxa.com');

define('COMPANY_WORKING_HOURS',8);

define('LUNCH_COST',35);

/*-[end]default company setting-*/



?>

