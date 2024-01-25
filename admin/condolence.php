<?php
    require_once './common/config/config.inc.php';
	require_once SOURCE_ROOT.'condolence/condolence_class/class.condolence.php'; 
	$objCondolence=Factory::getInstanceOf('Condolence');
	$cId=$_REQUEST['cId'];
	$result=$objCondolence->getCondolenceby_id($cId);
	print_r($result);
	if(empty($cId) || empty($result) ) { header("Location:".$_SERVER['HTTP_REFERER']);}
	
	
	
	
	
	
?>
<!-- NAVBAR -->
	<?php require_once SOURCE_ROOT.'header.inc.php'; ?>
<!-- END NAVBAR -->
<!-- LEFT SIDEBAR -->
		<?php require_once SOURCE_ROOT.'leftsidebar.inc.php'; ?>
<!-- END LEFT SIDEBAR -->

	<div class="main">
		<div class="panel">
			<div class="panel-heading">
			<h3 class="panel-title">View Condolence</h3>
			</div>
		</div>
		<?php if($_SESSION['msg']=='success'){?>
		<div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> Condolence has been added successfully!
        </div>
    <?php unset($_SESSION['msg']); } if($_SESSION['msg']=='failed'){?>
     <div class="alert alert-danger" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong>Error occur during processing.!
    </div>
   <?php unset($_SESSION['msg']); } ?>

<div class="panel-body">
<div class="row">
<div class="col-md-10">
<h2>Condolence Details</h2>

<table>
 <tr>
    <td>Obituaries Name</td>
    <td><?php echo $result[0]['ObituariesId'];?></td>
    
  </tr>
  <tr>
    <td>Description</td>
    <td><?php echo $result[0]['Description'];?></td>
    
  </tr>
  <tr>
    <td>Name</td>
    <td><?php echo $result[0]['FirstName'].' ' .$result[0]['LastName'];?></td>
   
  </tr>
  <tr>
    <td>RelationShip</td>
    <td><?php echo $result[0]['Relation'];?></td>
    
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $result[0]['Email'];?></td>
    
  </tr>
  <tr>
    <td>City</td>
    <td><?php echo $result[0]['City'];?></td>
    
  </tr>
  <tr>
    <td>State</td>
    <?php if($result[0]['State']=='n'){?>
     <td>Pending</td>
    <?php } else{ ?>
     <td>Approved</td>
    <?php } ?>
  
    
  </tr>
   <tr>
    <td>State</td>
    <td><?php  echo $varStatus = $result[0]['Status'];?></td>
   
  </tr>
   <tr>
    <td>Date Added:</td>
    <td><?php echo $result[0]['AddedDate'];?></td>
   
  </tr>
</table>
</div>
</div>
</div>
</div>

<div class="clearfix"></div>
<?php require_once SOURCE_ROOT.'footer1.inc.php'; ?>
<script>
	window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>