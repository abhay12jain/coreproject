<?php
    require_once '../common/config/config.inc.php';
?>
<!-- NAVBAR -->
	<?php require_once SOURCE_ROOT.'admin/header.inc.php'; ?>
<!-- END NAVBAR -->
<!-- LEFT SIDEBAR -->
		<?php require_once SOURCE_ROOT.'admin/leftsidebar.inc.php'; 
		
		require_once SOURCE_ROOT.'category/category_class/class.cateory.php';
		$objcategory=Factory::getInstanceOf('Category');
		$resultdata=$objcategory->getCategory();
	    
		?>
<!-- END LEFT SIDEBAR -->
	<!-- MAIN -->
		<div class="main">
			
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title">Add A New Post</h3>
					
					<div class="row">
						<div class="col-md-12">
							<!-- TABLE STRIPED -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Inputs</h3>
								</div>
								<div class="panel-body">
									<input type="text" class="form-control input-lg" placeholder="Post Title">
									<br>
									<textarea class="form-control input-lg" placeholder="textarea" rows="4"></textarea>
									<br>
									<select class="form-control input-lg">
										<option value="#">Select Category</option>
										<?php foreach($resultdata as $result){?>
											<option value="<?php echo $result['CategoryId'] ?>"><?php echo $result['CategoryName'] ?></option>
										<?php } ?>
							
									</select>
									<br>
									<label class="fancy-radio">
										<input name="gender" value="male" type="radio">
										<span><i></i>Male</span>
									</label>
									<label class="fancy-radio">
										<input name="gender" value="female" type="radio">
										<span><i></i>Female</span>
									</label></br>
                                    <div class="upload-btn-wrapper">
                                    <button class="btn">Upload a Image</button>
                                     <input type="file" name="myfile" />
                                     </div>

								</div>
							</div>
							<!-- END TABLE STRIPED -->
						</div>
						
					</div>
					
				</div>
			</div>
			<!-- END MAIN CONTENT -->

<div class="clearfix"></div>
<?php require_once SOURCE_ROOT.'admin/footer1.inc.php'; ?>
<!--<script type="text/javascript" src="<?php echo SITE_ROOT_URL;?>category/category_js/category.js"></script>-->
<script>
	window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>
<style type="text/css">
	.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn {
    border: 1px solid gray;
    color: gray;
    background-color: white;
    padding: 7px 20px;
    border-radius: 8px;
    font-size: 12px;
    /* font-weight: bold; */
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>