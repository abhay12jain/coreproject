<?php class Condolence extends Database {

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

	function getBlockedIP(){
		$arrCols = array('arrColumns'=>'IPAddress');
		$where="Status='b'";
        $arr_result=array();
       $arr_result=$this->select(TABLE_Condolence,$arrCols,$where);
       return $arr_result;

	}

	function addCondolence($argPostData){
		
   if($_FILES['Condolences_file_name']['name']!='' && $_FILES['Condolences_file_name']['name']!='')	{

	   $fileTmpPath = $_FILES['Condolences_file_name']['tmp_name'];
       $fileName = $_FILES['Condolences_file_name']['name'];
       $fileSize = $_FILES['Condolences_file_name']['size'];
       $fileType = $_FILES['Condolences_file_name']['type'];
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

            $uploadFileDir = './admin/common/uploaded_files/condolences/';
            $dest_path = $uploadFileDir . $newFileName;

			 

			if(move_uploaded_file($fileTmpPath, $dest_path))

			{

				$arrCols = array ('ObituariesId'=>$argPostData['ObituariesId'],

						'FirstName'=>$argPostData ['FirstName'],

						'LastName'=>$argPostData ['LastName'],

						'Relation'=>$argPostData ['Relation'],

						'AddImage'=>$newFileName,
                        'IPAddress'=>$argPostData['ip_address'],
						'Description'=>$argPostData ['Description'],

						'Email'=>$argPostData ['Email'],

						'City'=>$argPostData ['City'],

						'State'=>$argPostData ['State'],

						'Status'=>$argPostData ['Status'],

					  'AddedDate'=>date("Y-m-d H:i:s"),
					  'LastModifiedDate'=>date("Y-m-d H:i:s")
					);

		       $inserted_ID = $this->insert(TABLE_Condolence,$arrCols);

			   return $inserted_ID;

			   die;

			   //$message ='File is successfully uploaded.';

			}

			else

			{

			   $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';

			   return $message;

			   die();

			}



		} else {

			 $message = 'File type is not valid.';

			return $message;

			die();

		}



	}
	else{
		$arrCols = array ('ObituariesId'=>$argPostData['ObituariesId'],
                     
                     'FirstName'=>$argPostData ['FirstName'],
                     'LastName'=>$argPostData ['LastName'],
                     'Relation'=>$argPostData ['Relation'],
                     'AddImage'=>'',
                     'IPAddress'=>$argPostData['ip_address'],
					  'Description'=>$argPostData ['Description'],
                      'Email'=>$argPostData ['Email'],
                      'City'=>$argPostData ['City'],
                      'State'=>$argPostData ['State'],
                      'Status'=>$argPostData ['Status'],
                      'AddedDate'=>date("Y-m-d H:i:s"),
                      'LastModifiedDate'=>date("Y-m-d H:i:s")
                  );

		       $inserted_ID = $this->insert(TABLE_Condolence,$arrCols);

			   return $inserted_ID;

			   die;
	}
}

	

	function getCondolence(){

		$arrCols = array('arrColumns'=>'*');

		$where='1';

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Condolence,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}
	function getCondolenceDetails($arrCols='',$where='',$orderBy='',$limit = ''){

		$arrCols = array('arrColumns'=>'*');

		$where='1';

		$orderBy='';

		$limit=$limit;

		$arr_result=array();

		$arr_result=$this->select(TABLE_Condolence,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}

	

    function getCondolenceby_id($cId){

    	$arrCols = array('arrColumns'=>'*');

		$where="CondolenceId=$cId";

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Condolence,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

    }



    function getTotalcondolence(){

		$arrCols = array('arrColumns'=>'COUNT(*) as  total_record');

		$where='1';

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Condolence,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

	}

     

    function getAppronveCondolence($cId,$Status){

    	$arrCols = array('arrColumns'=>'*');

		$where="ObituariesId=$cId AND Status='$Status'";

		$orderBy='';

		$limit='';

		$arr_result=array();

		$arr_result=$this->select(TABLE_Condolence,$arrCols,$where,$orderBy,$limit);

     return $arr_result;

    }







    function updateCondolence(){

    	//print_r($_POST);die;

    	$arrCols =  array ('ObituariesId'=>$argPostData['ObituariesId'],

						'FirstName'=>$argPostData ['FirstName'],

						'LastName'=>$argPostData ['LastName'],

						'Relation'=>$argPostData ['Relation'],

						'Email'=>$argPostData ['Email'],

						'City'=>$argPostData ['City'],

						'State'=>$argPostData ['State'],

						'Description'=>$argPostData ['description'],

						'Status'=>'n',

						'AddedDate'=>date("Y-m-d H:i:s"));

    	$cId=$_POST['cId'];

    	 $where="CondolenceId=$cId";

    	//print_r($arrCols);

    	//die();

    	$arr_result=$this->update(TABLE_Condolence,$arrCols,$where);

        return $arr_result;

    }



   function changeStatus($CondolenceId,$currentstatus){

   	if($currentstatus=='y'){
   	$changeStatus='n';	
   	}
   	elseif($currentstatus=='n'){
   			$changeStatus='y';
   	}
    else{
    	$changeStatus='n';
    }
     $arrCols =  array ('Status'=>$changeStatus,
     'LastModifiedDate'=>date("Y-m-d H:i:s"));
     $where="CondolenceId=$CondolenceId";		

   $arr_result=$this->update(TABLE_Condolence,$arrCols,$where);

   return $arr_result;

   }
    
    
function ipBlocked($CondolenceId,$currentstatus){

    $arrCols =  array ('Status'=>$currentstatus,
    'LastModifiedDate'=>date("Y-m-d H:i:s"));

    $where="CondolenceId=$CondolenceId";		

   $arr_result=$this->update(TABLE_Condolence,$arrCols,$where);

   return $arr_result;

   }
    function deleteCondolence(){

    	

		

    	//$arrCols =  array ('Status'=>$argPostData['status'],

		//'LastModifiedDate'=>date("Y-m-d H:i:s"));

		$cId=$_REQUEST['cId'];

		$where="CondolenceId=$cId";

		//print_r($arrCols);

		//die();

		$arr_result=$this->delete(TABLE_Condolence,$where);

		return $arr_result;





    }



	}