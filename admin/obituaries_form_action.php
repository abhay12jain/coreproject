<?php

require_once './common/config/config.inc.php';

require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php'; 

$objObituaries=Factory::getInstanceOf('Obituaries');

//$ref_to_page=$_SESSION['emp_current_page'];//used to refer on current page

//$action=$_REQUEST['action'];

$action= $_POST['action'];

//print_r($_POST);die;

if($action=='addObituaries')

{
  $ObituariesID=$objObituaries->addObituaries($_POST);
  
  if($ObituariesID)
   {		
   $_SESSION['msg']="success";
    header('location:obituarieslist.php?msg='.$_SESSION['msg']);
    }	
   else{
   $_SESSION['msg']="failed";
   header('location:obituarieslist.php?msg='.$_SESSION['msg']);
   }

		//die;

} 

elseif($_POST['action']=='displayallcate'){

	$result=$objObituaries->getObituaries();

	$_SESSION['Obituaries_list']=$result;

	header('location:obituarieslist.php');

}



elseif($_POST['action']=='updateObituaries'){



  $updatedid=$objObituaries->updateObituaries();

	 if($updatedid)

		{		

			$_SESSION['msg']="success";

			header('location:obituarieslist.php?msg='.$_SESSION['msg']);

			die();

		}	

		else

		{

			$_SESSION['msg']="failed";

			header('location:obituarieslist.php?msg='.$_SESSION['msg']);

			die();

			

		}



}

elseif($_REQUEST['action']=='editObituaries'){

   $catid=$_REQUEST['catID'];

   $result=$objObituaries->getObituariesby_id($catid);

   $_SESSION['edit_data']=$result;

   header('location:obituaries.php');

  die();

  //header('location:Obituaries.php');

 }

 elseif($_REQUEST['action']=='deleteObituaries'){



 	 $catid=$_REQUEST['catID'];

 	  $deleted_id=$objObituaries->deleteObituaries($catid);

 	 //die;

 	 if(isset($deleted_id))

		{		
			$_SESSION['msg']="success";

			header('location:'.$_SERVER['HTTP_REFERER'].'?msg='.$_SESSION['msg']);

			die();

		}	

		else

		{

			$_SESSION['msg']="failed";

			header('location:'.$_SERVER['HTTP_REFERER'].'?msg='.$_SESSION['msg']);

			die();

			

		}

 }

?>