<?php require_once './common/config/config.inc.php'; ?>

<!-- NAVBAR -->

	<?php require_once SOURCE_ROOT.'header.inc.php'; ?>

<!-- END NAVBAR -->

<!-- LEFT SIDEBAR -->

		<?php require_once SOURCE_ROOT.'leftsidebar.inc.php'; 
        require_once SOURCE_ROOT.'common/classes/class.paging.php';
		require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';
		$objPaging=Factory::getInstanceOf('Paging');
        $objObituaries=Factory::getInstanceOf('Obituaries');
        $recode=$objObituaries->getTotalObituaries();

        /*paging*/
        $recordPerPage=5;
        $varPageStart = $objPaging->getPageStartLimit($_GET['page'],$recordPerPage);
        $varLimit = $varPageStart.','.$recordPerPage;
        $orderBy='AddedDate DESC';

		//$resultdata=$objObituaries->getObituaries();
		$resultdata=$objObituaries->getObituariesDetails('','','',$varLimit);


		$totalRecord = $recode[0]['total_record']; 
        $varNumberPages = $objPaging->calculateNumberofPages($totalRecord,$recordPerPage);
        //$count=0;


		?>

<!-- END LEFT SIDEBAR -->

	<!-- MAIN -->

		<div class="main">

			<?php if($_SESSION['msg']=='success'){?>

		   <div class="alert alert-success" role="alert">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          <strong>Success!</strong> Obituaries has been updated successfully!

        </div>

    <?php unset($_SESSION['msg']); } if($_SESSION['msg']=='failed'){?>

     <div class="alert alert-danger" role="alert">

     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <strong>Error!</strong>Error occur during processing.!

    </div>

   <?php unset($_SESSION['msg']); unset($_SESSION['edit_data']);} ?>

			<!-- MAIN CONTENT -->

			<div class="main-content">

				<div class="container-fluid">

					<h3 class="page-title">Obituaries List</h3>

					

					<div class="row">

						<div class="col-md-12">

							<!-- TABLE STRIPED -->

							<div class="panel">

								<div class="panel-heading">

									<h3 class="panel-title">Obituaries List</h3>

									<?php //print_r($_SESSION['Obituaries_list']);?>

								</div>

								<div class="panel-body">
                                      <?php if($resultdata) {?>
									<table class="table table-striped">

										<thead>

											<tr>

												<th>S.No</th>

												<th>Obituaries Name</th>

												<th>Images</th>

												<th>Description</th>
                                                <th>City</th>
												<th>Date</th>

												<th>Action</th>

											</tr>

										</thead>

										<tbody>

											<?php  $i=1; 

											 
												foreach($resultdata as $result){ 

                                                // echo '<pre>';

												//print_r($result);

											$imagename=$result['ObituariesFileName'];

											if($imagename){

								            $image_url=SITE_ROOT_URL.'common/uploaded_files/obituaries/'.$imagename;
											}else{
												$image_url ='';
												}
								            

								           ?>

											<tr>

												<td><?php echo $varPageStart+$i;?></td>

												<td><?php echo $result['ObituariesName'];?></td>

												<td><?php if($image_url){ ?><img src="<?php echo $image_url?>" width="100" height="100"><?php }?></td>

												<td><?php echo html_entity_decode(substr($result['Description'],0,175));?></td>
												<td><?php echo $result['ObituariesLocation'];?></td>

												<td><?php $date = new DateTime($result['AddedDate']); echo date_format($date,"M d, Y");?></td>

                                                <td><a title="Edit" href="<?php echo SITE_ROOT_URL;?>obituaries.php?catID=<?php echo $result['ObituariesId']?>"  class="btn btn-info">Edit</a></td>

												<td><a href="<?php echo SITE_ROOT_URL;?>obituaries_form_action.php?catID=<?php echo $result['ObituariesId']?>&action=deleteObituaries" class="btn btn-info">Delete</a></td>

											</tr>

											<?php $i++;}  ?>
											
										</tbody>

									</table>
									<?php if($totalRecord>5){?>
                                        <div class="pagination clear"><?php $objPaging->displayPaging($_GET['page'], $varNumberPages, $recordPerPage); ?></div>
                                         <?php }} else{?>
                                                   <div class="notes">Result not found..</div>
                                       <?php  } ?>

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

<!--<script type="text/javascript" src="<?php echo SITE_ROOT_URL;?>obituaries/obituaries_js/obituaries.js"></script>-->

<script>

	window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 

    });

}, 4000);

</script>