<?php

    require_once './common/config/config.inc.php';

	require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';

	$objObituaries=Factory::getInstanceOf('Obituaries');

	$catid=$_REQUEST['catID'];

	if(isset($catid)){

		$result=$objObituaries->getObituariesby_id($catid);

	}

	

	//print_r($result);

?>



<!-- NAVBAR -->

	<?php require_once SOURCE_ROOT.'header.inc.php'; ?>

<!-- END NAVBAR -->

<!-- LEFT SIDEBAR -->

		<?php require_once SOURCE_ROOT.'leftsidebar.inc.php'; ?>

<!-- END LEFT SIDEBAR -->

<?php //print_r($_SESSION['edit_data']);?>



<div class="main">

      <!-- MAIN CONTENT -->

      <div class="main-content">

        <div class="container-fluid">

          <h3 class="page-title">Add New Obituaries</h3>

          <div class="row">

            <div class="col-md-6">

              <?php if($_SESSION['msg']=='success'){?>

                  <div class="alert alert-success" role="alert">

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                      <strong>Success!</strong> Obituaries has been added successfully!

                      </div>

                  <?php unset($_SESSION['msg']); } if($_SESSION['msg']=='failed'){?>

                   <div class="alert alert-danger" role="alert">

                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                      <strong>Error!</strong>Error occur during processing.!

                  </div>

                 <?php unset($_SESSION['msg']); } ?>

                 <form class="ad-category-form" id="add_obituaries" method="post" action="obituaries_form_action.php" method="post" enctype="multipart/form-data">    

            <input class="form-control input-lg" name="Obituaries_name" placeholder="Obituaries Name" type="text"  value="<?php echo $result[0]['ObituariesName']?>"></br>

            <input class="form-control input-lg" name="ObituariesLocation" placeholder="Obituaries Location" type="text"  value="<?php echo $result[0]['ObituariesLocation']?>"></br>
            <input class="form-control input-lg" name="ObituariesDate" placeholder="Obituaries Date" id="date" type="text"  value="<?php echo $result[0]['ObtituariesDate']?>"></br>

            <textarea class="form-control input-lg" name="description" placeholder="Obituaries Description" id="editor" rows="10" cols="80" >

              <?php echo $result[0]['Description']?></textarea></br>

                        <input type="hidden" name="action" <?php $catid ? $value="updateObituaries" : $value="addObituaries";?> value="<?php echo $value;?>">

                            

                            <?php if($result){ //echo '<pre>';print_r($result);

                   $imagename=$result[0]['ObituariesFileName'];

                   $image_url=SITE_ROOT_URL.'common/uploaded_files/obituaries/'.$imagename;?>

                                    <div class="avatar-upload">

                        <div class="avatar-edit">

                            <input type='file' name="Obituaries_file_name"id="imageUpload" accept=".png, .jpg, .jpeg" />

                            <label for="imageUpload"></label>

                        </div>

                        <div class="avatar-preview">

                            <div id="imagePreview" style="background-image: url(<?php echo $image_url;?>);">

                            </div>

                        </div>

                    </div>

                  

                        <?php } else{?>

                          <input type="file" class="class_text" name="Obituaries_file_name" id="Obituaries_file_name" /><br>

                        <?php }?>

            <input type="hidden" name="catID"   value="<?php echo $result[0]['ObituariesId'];?>">

                        <input type="submit" value="Submit" class="btn btn-primary btn-lg" />

                       </form>

              </div>

              <!-- END BUTTONS -->

              <!-- INPUTS -->

              

              </div>

              <!-- END INPUTS -->

              <!-- INPUT SIZING -->



              </div>

              <!-- END INPUT SIZING -->

            </div>

            

              

              <!-- END ALERT MESSAGES -->

            </div>

          </div>

        </div>

      </div>

      <!-- END MAIN CONTENT -->

    </div>

<div class="clearfix"></div>

<?php require_once SOURCE_ROOT.'footer1.inc.php'; ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<script src="<?php echo SITE_ROOT_URL?>common/js/jquery.validate.js"></script> 
<script src="<?php echo SITE_ROOT_URL?>common/js/form_validation.js"></script> 

<script>

  	CKEDITOR.replace('editor', {

  skin: 'moono',

  enterMode: CKEDITOR.ENTER_BR,

  shiftEnterMode:CKEDITOR.ENTER_P,

  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },

             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },

             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },

             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },

             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },

             { name: 'links', items: [ 'Link', 'Unlink' ] },

             { name: 'insert', items: [ 'Image'] },

             { name: 'spell', items: [ 'jQuerySpellChecker' ] },

             { name: 'table', items: [ 'Table' ] }

             ],

});



  </script>
   <script>
    $(document).ready(function(){
      var date_input=$('input[name="ObituariesDate"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy/mm/dd/', 
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
<script type="text/javascript">

	window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 

    });

}, 4000);

</script>

<script>

	function readURL(input) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {

            $('#imagePreview').css('background-image', 'url('+e.target.result +')');

            $('#imagePreview').hide();

            $('#imagePreview').fadeIn(650);

        }

        reader.readAsDataURL(input.files[0]);

    }

}

$("#imageUpload").change(function() {

    readURL(this);

});

</script>

<style>

	.avatar-upload {

  position: relative;

  max-width: 205px;

  margin: 50px auto;

}

.avatar-upload .avatar-edit {

  position: absolute;

  right: 12px;

  z-index: 1;

  top: 10px;

}

.avatar-upload .avatar-edit input {

  display: none;

}

.avatar-upload .avatar-edit input + label {

  display: inline-block;

  width: 34px;

  height: 34px;

  margin-bottom: 0;

  border-radius: 100%;

  background: #FFFFFF;

  border: 1px solid transparent;

  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);

  cursor: pointer;

  font-weight: normal;

  transition: all 0.2s ease-in-out;

}

.avatar-upload .avatar-edit input + label:hover {

  background: #f1f1f1;

  border-color: #d6d6d6;

}

.avatar-upload .avatar-edit input + label:after {

  content: "\f040";

  font-family: 'FontAwesome';

  color: #757575;

  position: absolute;

  top: 10px;

  left: 0;

  right: 0;

  text-align: center;

  margin: auto;

}

.avatar-upload .avatar-preview {

  width: 192px;

  height: 192px;

  position: relative;

  border-radius: 100%;

  border: 6px solid #F8F8F8;

  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

}

.avatar-upload .avatar-preview > div {

  width: 100%;

  height: 100%;

  border-radius: 100%;

  background-size: cover;

  background-repeat: no-repeat;

  background-position: center;

}

.container {

  max-width: 960px;

  margin: 30px auto;

  padding: 20px;

}

h1 {

  font-size: 20px;

  text-align: center;

  margin: 20px 0 20px;

}

h1 small {

  display: block;

  font-size: 15px;

  padding-top: 8px;

  color: gray;

}

</style>

