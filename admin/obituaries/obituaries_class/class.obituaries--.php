<?php class Obituaries extends Database {

	public $objCore;

	public $objValid;

	public $objGeneral;

	

	function __construct() {

		parent::__construct();

		$this->objCore = Factory::getInstanceOf ( 'Core' );

		$this->objValid = Factory::getInstanceOf ( 'Validate_fields' );

		$this->objGeneral = Factory::getInstanceOf ( 'General' );

		//his->objOrder=Factory::getInstanceOf('General');

	}

	

	function addObituaries($argPostData){



		// get details of the uploaded file

		$fileTmpPath = $_FILES['Obituaries_file_name']['tmp_name'];

		$fileName = $_FILES['Obituaries_file_name']['name'];

		$fileSize = $_FILES['Obituaries_file_name']['size'];

		$fileType = $_FILES['Obituaries_file_name']['type'];

		$fileNameCmps = explode(".", $fileName);

		$fileExtension = strtolower(end($fileNameCmps));

		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

		$image_type_identifiers = array (

			'image/gif' => 'gif',

			'image/jpeg' => 'jpg',

			'image/png' => 'png',

			'image/pjpeg' => 'jpg',

			'image/x-png' => 'png'

		);

		if (array_key_exists($fileType, $image_type_identifiers)) {

			

			$uploadFileDir = './common/uploaded_files/obituaries/';

			$dest_path = $uploadFileDir . $newFileName;

			 

			if(move_uploaded_file($fileTmpPath, $dest_path))

			{

			  $arrCols = array ('ObituariesName'=>$argPostData['Obituaries_name'],

						'Description'=>$argPostData['description'],

						//'ObituariesFileName'=>$argPostData['Obituaries_file_name'],

						'ObituariesFileName'=>$newFileName,

						'AddedDate'=>date("Y-m-d H:i:s"));

		

					$inserted_ID = $this->insert(TABLE_Obituaries,$arrCols);

					return $inserted_ID;	

			   //$message ='File is successfully uploaded.';

			}

			else

			{

			   $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';

			   return $message;die();

			}



		} else {

			 $message = 'File type is not valid.';

			return $message;die();

		}



		//print_r($_FILES); 		print_r($arrCols);die;



		

	

	}

	

	function getObituaries(){

		$arrCols = array('arrColumns'=>'*');

		$where='1';

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Obituaries,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}

	function getCurrentObituaries(){

		$arrCols = array('arrColumns'=>'*');

		$where='1';

		$orderBy='AddedDate DESC';

		$limit='4';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Obituaries,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}

	function getTotalObituaries(){

		$arrCols = array('arrColumns'=>'COUNT(*) as  total_record');

		$where='1';

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Obituaries,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}

    function getObituariesby_id($catid){

    	$arrCols = array('arrColumns'=>'*');

		$where="ObituariesId=$catid";

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Obituaries,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

    }



    function updateObituaries(){

    	//print_r($_POST);

    $catid=$_POST['catID'];

    if($_FILES['Obituaries_file_name']['name']!='' && $_FILES['Obituaries_file_name']['name']!='')	{



     $fileTmpPath = $_FILES['Obituaries_file_name']['tmp_name'];

		$fileName = $_FILES['Obituaries_file_name']['name'];

		$fileSize = $_FILES['Obituaries_file_name']['size'];

		$fileType = $_FILES['Obituaries_file_name']['type'];

		$fileNameCmps = explode(".", $fileName);

		$fileExtension = strtolower(end($fileNameCmps));

		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

		$image_type_identifiers = array (

			'image/gif' => 'gif',

			'image/jpeg' => 'jpg',

			'image/png' => 'png',

			'image/pjpeg' => 'jpg',

			'image/x-png' => 'png'

		);

		if (array_key_exists($fileType, $image_type_identifiers)) {

			

			$uploadFileDir = './common/uploaded_files/obituaries/';

			$dest_path = $uploadFileDir . $newFileName;

			 

			if(move_uploaded_file($fileTmpPath, $dest_path))

			{

			  $arrCols = array ('ObituariesName'=>$_POST['Obituaries_name'],

						'Description'=>$_POST ['description'],

						'ObituariesFileName'=>$newFileName,

						'ModifiedDate'=>date("Y-m-d H:i:s")

					);

		     $where="ObituariesId=$catid";

			$arr_result=$this->update(TABLE_Obituaries,$arrCols,$where);

           return $arr_result;		

			}

			else

			{

			   $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';

			   return $message;die();

			}



		} else {

			 $message = 'File type is not valid.';

			return $message;die();

		}

    	

    }

    else{

    	 $arrCols = array ('ObituariesName'=>$_POST['Obituaries_name'],

						'Description'=>$_POST ['description'],

						//'ObituariesFileName'=>$newFileName,

						'ModifiedDate'=>date("Y-m-d H:i:s")

					);

		     $where="ObituariesId=$catid";

			$arr_result=$this->update(TABLE_Obituaries,$arrCols,$where);

           return $arr_result;		



    }

   }

    function deleteObituaries($catid){

    	//echo '@@@@@22222';

    	$where="ObituariesId=$catid";

    	$arr_result=$this->delete(TABLE_Obituaries,$where);

        return $arr_result;

    }



	}