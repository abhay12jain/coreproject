<?php 
require_once './common/config/config.inc.php'; ?>

<!-- NAVBAR -->

	<?php require_once SOURCE_ROOT.'header.inc.php'; ?>

<!-- END NAVBAR -->

<!-- LEFT SIDEBAR -->

		<?php require_once SOURCE_ROOT.'leftsidebar.inc.php'; 

		require_once SOURCE_ROOT.'condolence/condolence_class/class.condolence.php';
		 require_once SOURCE_ROOT.'common/classes/class.paging.php';
		$objPaging=Factory::getInstanceOf('Paging');

		$objCondolence=Factory::getInstanceOf('Condolence');

		 $recordPerPage=5;
        $varPageStart = $objPaging->getPageStartLimit($_GET['page'],$recordPerPage);
        $varLimit = $varPageStart.','.$recordPerPage;

		$resultdata=$objCondolence->getCondolenceDetails('','','',$varLimit);
		$recode=$objCondolence->getTotalcondolence();

	    $totalRecord = $recode[0]['total_record']; 
        $varNumberPages = $objPaging->calculateNumberofPages($totalRecord,$recordPerPage);
		?>

<!-- END LEFT SIDEBAR -->

	<!-- MAIN -->

		<div class="main">

			<?php if($_SESSION['msg']=='success'){?>

		   <div class="alert alert-success" role="alert">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          <strong>Success!</strong> Condolence status has been updated successfully!

        </div>

    <?php unset($_SESSION['msg']); } if($_SESSION['msg']=='failed'){?>

     <div class="alert alert-danger" role="alert">

     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <strong>Error!</strong>Error occur during processing.!

    </div>

   <?php unset($_SESSION['msg']);} ?>

			<!-- MAIN CONTENT -->

			<div class="main-content">

				<div class="container-fluid">

					<h3 class="page-title">Condolence List</h3>

					

					<div class="row">

						<div class="col-md-12">

							<!-- TABLE STRIPED -->

							<div class="panel">

								<div class="panel-heading">

									<h3 class="panel-title">Condolence List</h3>

								</div>

								<div class="panel-body">

								<?php if($resultdata) {  ?>

									<table class="table table-striped">

										<thead>

											<tr>

												<th><b>S.No</b></th>

												<th><b>Name</b></th>

												<th><b>Image</b></th>

												<th><b>Description</b></th>
												<th><b>IP Address</b></th>

												<th><b>Status</b></th>

												<th><b>Action</b></th>

											</tr>

										</thead>

										<tbody>

											<?php  $i=1; foreach($resultdata as $result){ 

												if($result['AddImage'])

												$image=$result['AddImage'];

											    else

											    $image=SITE_ROOT_URL.'common/images/placeholder.jpg';	

												?>

											<tr>
                                                 
												<td><?php echo $varPageStart+$i;?></td>

												<td><?php echo $result['FirstName'].' '. $result['LastName'];?></td>

												<td>  <img class="headImg" src="<?php echo SITE_ROOT_URL?>common/uploaded_files/condolences/<?php echo $image ?>" alt="" width="100px" height="100px"></td>

												<td><?php  echo substr($result['Description'],0,175).'.....';?></td>
												<td><?php  echo $result['IPAddress'];?></td>

                                                

                                                <?php if($result['Status']=='y'){

                                                ?>

                                                <td><storng><b class="btn btn-success">Approved</b></storng></td>

                                            <?php } else if($result['Status']=='n'){?>

                                            	<td><b class="btn btn-warning">Pending</b></td>

                                            <?php } else{ ?>
                                            <td><b class="btn btn-danger">IP Blocked</b></td>

                                           <?php  }?>
                                                
                                                <td><a href="<?php echo SITE_ROOT_URL;?>condolence_action.php?cId=<?php echo $result['CondolenceId']?>&action=changeStatus&status=<?php echo $result['Status']?>" class="btn btn-info">Change Status</a></td>
                                           

                                                 <td><a href="<?php echo SITE_ROOT_URL;?>condolence_action.php?cId=<?php echo $result['CondolenceId']?>&action=ipBlocked&status=b" class="btn btn-info">IP Blocked</a></td>


                                                <td><a href="<?php echo SITE_ROOT_URL;?>condolence.php?cId=<?php echo $result['CondolenceId']?>" class="btn btn-info">View</a></td>

												<td><a href="<?php echo SITE_ROOT_URL;?>condolence_action.php?cId=<?php echo $result['CondolenceId']?>&action=deleteCondolence" class="btn btn-info">Delete</a></td>

                                        

											</tr>

											<?php $i++;} //unset($_SESSION['Condolence_list']);?>

										</tbody>

									</table>

											<?php if($totalRecord>5){?>
                                             <div class="pagination clear"><?php $objPaging->displayPaging($_GET['page'], $varNumberPages, $recordPerPage); ?></div>  
											

											<?php }}else {  
												echo '<div class="notes">Result not found..</div>'; 
											} ?>	

								</div>

							</div>

							<!-- END TABLE STRIPED -->

						</div>

					</div>

				</div>

			</div>

			<!-- END MAIN CONTENT -->

<div class="clearfix"></div>

<?php require_once SOURCE_ROOT.'footer1.inc.php'; ?>



<script>

	window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 

    });

}, 4000);

</script>