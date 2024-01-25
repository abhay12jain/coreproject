<?php

require_once './admin/common/config/config.inc.php';

require_once SOURCE_ROOT.'condolence/condolence_class/class.condolence.php'; 

$objCondolence=Factory::getInstanceOf('Condolence');


$action= $_POST['action'];



if($action=='checkIPAddress')
{
 
 $allblockedIP=$objCondolence->getBlockedIP();
 //print_r( $allblockedIP);
 foreach($allblockedIP as $blockip){
 	$allblockip[]=$blockip['IPAddress'];
 }

//print_r($allblockip);
echo $_POST['ip_address'];
 if(in_array($_POST['ip_address'],$allblockip)){
 	 $_SESSION['msg']="ipblocked";
 	  header('location:'.$_SERVER['HTTP_REFERER'].'&msg='.$_SESSION['msg'].'#alert-msg');
     die();

 }

 else
 {	
 $objCondolenceID=$objCondolence->addCondolence($_POST);
 
 if($objCondolenceID)
  {	
          $_SESSION['msg']="Success";
            header('location:'.$_SERVER['HTTP_REFERER'].'&msg='.$_SESSION['msg'].'#alert-msg');
           die();

		}	

		else

		{
            $_SESSION['msg']="failed";
             header('Location: '.$_SERVER['HTTP_REFERER'].'&msg='.$_SESSION['msg'].'#alert-msg');
             die();
         }

	}	

} 

elseif($_REQUEST['action']=='changeStatus'){

	 $cId=$_REQUEST['cId'];

	$current_status=$_REQUEST['status'];



	 $updatedID=$objCondolence->changeStatus($cId,$current_status);

	 if($updatedID){

	 	$_SESSION['msg']="success";

			header('Location:'.$_SERVER['HTTP_REFERER']);

			die;

     }else{

     	$_SESSION['msg']="failed";

			header('Location:'.$_SERVER['HTTP_REFERER']);

			die;



     }



}
elseif($_REQUEST['action']=='ipBlocked'){

	 $cId=$_REQUEST['cId'];

	$current_status=$_REQUEST['status'];
   $updatedID=$objCondolence->ipBlocked($cId,$current_status);

	 if($updatedID){

	 	$_SESSION['msg']="success";

			header('Location:'.$_SERVER['HTTP_REFERER']);

			die;

     }else{

     	$_SESSION['msg']="failed";

			header('Location:'.$_SERVER['HTTP_REFERER']);

			die;



     }



}

/*elseif($_POST['action']=='displayallcate'){

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

 }*/

 elseif($_REQUEST['action']=='deleteCondolence'){



 	 $catid=$_REQUEST['cId'];

 	  $deleted_id=$objCondolence->deleteCondolence($catid);

 	 //die;

 	 if(isset($deleted_id))

		{		

			$_SESSION['msg']="success";

			header('location:condolencelist.php?msg='.$_SESSION['msg']);

			die();

		}	

		else

		{

			$_SESSION['msg']="failed";

			header('location:condolencelist.php?msg='.$_SESSION['msg']);

			die();

			

		}

 }

?>