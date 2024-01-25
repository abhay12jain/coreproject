<?php

    require_once './admin/common/config/config.inc.php';

	require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';

	require_once SOURCE_ROOT.'condolence/condolence_class/class.condolence.php';
  require_once 'common/custom_function.php';


	$objObituaries=Factory::getInstanceOf('Obituaries');

	$objCondolence=Factory::getInstanceOf('Condolence');

	$cId=$_REQUEST['cId'];

	$resultdata=$objObituaries->getObituariesby_id($cId);

  //print_r($resultdata);

	//$all_condolence=$objCondolence->getCondolenceby_obituariesID($cId);

	$all_condolence=$objCondolence->getAppronveCondolence($cId,'y');

	//echo '<pre>';

	//print_r($all_condolence);

?>

<?php require_once('header.php');?>

    <!-- END header_part -->

    <!-- START content_part-->

    <div id="content_part">

        <!-- START innerbanner -->

        <div class="innerbanner" style="background-image: url(common/images/fredebanner.jpg);">

            <div class="overlay">

                <div class="container">

                    <h1><?php echo $resultdata[0]['ObituariesName']?></h1>

                </div>

            </div>

        </div>

        <!-- END innerbanner -->



        <!-- START frederick_part -->

        <section class="frederick_part">        

            <div class="container">

                     <?php 
                     foreach($resultdata as $result){?>

                <div class="row itembox">

                    <div class="text col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">

                      <?php 
                      if($result['ObituariesFileName']!=''){ $image=$result['ObituariesFileName'];?>

                        <div class="image">

                          <img class="headImg" src="<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>" alt="" width="438" height="438">

                        </div>

                      <?php } else{?>

                            <img class="headImg" src="common/images/placeholder.jpg" alt="" width="438" height="438">

                      <?php }?>

                    </div>

                    <div class="textt col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">

                        <div class="subtext">

                        

                            <h2><?php echo $result['ObituariesName'] ?></h2>

                            <span><?php $date=date_create($result['ObtituariesDate']);

							                 echo date_format($date,"M-d-Y"); ?></span>

                            <p><?php  echo $result['Description'];?></p>

                           

                        </div>

                    </div>

                </div>          

                 <?php }?>

            </div> 

        </section>

        <!-- END frederick_part -->



        <!-- START obituardetails_part -->

        <section class="obituardetails_part">

            <div class="container">



                <div class="row">

                   <?php if($all_condolence){

					      foreach($all_condolence as $condolence){

							  $name=$condolence['FirstName'].''.$condolence['LastName'];

							  $add_condolence_date=$condolence['AddedDate'];

							  $date=date_create($add_condolence_date);

							  $condolence_date=date_format($date,"M-d-Y");

							  $Relation=$condolence['Relation'];

							  $City=$condolence['City'];

							  $state=$condolence['State'];

							  $image=$condolence['AddImage'];

							  

					 ?>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="itemBox"> 
                        <?php if($image){?>  
                        <img class="headImg" src="<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/condolences/<?php echo $image ?>" alt="">   
                        <?php }?>                    

                            <p><?php echo $condolence['Description']?></p>

                            <img src="common/images/headImg_02.png" alt="">

                            <h3><?php echo $name; ?></h3>

                            <span><?php echo $condolence_date; ?> | <?php echo  $City ?>, <?php echo  $state ?> | <?php echo  $Relation ?></span>

                        </div>

                    </div>

					<?php }} else{?>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="itemBox">  

                         <p>No Condolence fonnd </p>  

                        </div>

                        </div>

                   <?php }?>



                </div>



            </div>

        </section>

        <!-- END obituardetails_part -->



        <!-- START send_part -->

        <section class="send_part" id="alert-msg">


            <div class="container">
              <?php $ip_address=get_client_ip();
              if($_SESSION['msg']=='Success'){ ?>
               <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-check-circle"></i> your Condolence has been Added Successfully.!Please Wait for Approval
                  </div>
                <?php unset($_SESSION['msg']);
              }  if($_SESSION['msg']=='failed'){ ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-times-circle"></i> Something is Wrong.Please Try again.!
                  </div>

                <?php unset($_SESSION['msg']); } if($_SESSION['msg']=='ipblocked'){?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-times-circle"></i>Your IP has been blocked. Please contect to the Site admin!
                  </div>

                <?php unset($_SESSION['msg']);} ?>

                <h2>Send Condolence </h2>

                    <img src="common/images/sendheadImg01.png" alt="">

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni </p>

                <div class="itembox">               

                    <form action="condolence_action.php" method="post" name="condolence-form" id="condolence-form" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                <textarea name="Description" cols="30" rows="6" class="" placeholder="what would you like to say to Fredrick John"></textarea>

                            </div>

                            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">

                                <div class="row">

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <input type="text" class="Inptfild" name="FirstName" placeholder="First Name">

                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <input type="text" class="Inptfild" name="LastName" placeholder="Last Name">

                                    </div>

                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">

                                <select class="selectfild" name="Relation">

                                    <option value="">Choose Relationship</option>

                                    <option value="Father">Father</option>

                                    <option value="Mother">Mother</option>

                                    <option value="Husband">Husband</option>

                                      <option value="Wife">Wife</option>

                                      <option value="Brother">Brother</option> 

                                      <option value="Son">Son</option>   

                                      <option value="Daughter">Daughter</option>   

                                      <option value="Sister">Sister</option> 

                                      <option value="Cousion">Cousion</option> 

                                     <option value="uncle">Uncle</option> 

                                    <option value="aunt">aunt</option>

                                     <option value="Friend">Friend</option>

                                      </select>

                            </div>

                            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">

                                <div class="row">

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <input type="text" class="Inptfild" name="City" placeholder="City">

                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <select class="selectfild" name="State">

                                            <option value="">State/Province</option>

                                              <option value="AL">Alabama</option>

                                              <option value="AK">Alaska</option>

                                              <option value="AZ">Arizona</option>

                                              <option value="AR">Arkansas</option>

                                              <option value="CA">California</option>

                                              <option value="CO">Colorado</option>

                                              <option value="CT">Connecticut</option>

                                              <option value="DE">Delaware</option>

                                              <option value="DC">District Of Columbia</option>

                                              <option value="FL">Florida</option>

                                              <option value="GA">Georgia</option>

                                              <option value="HI">Hawaii</option>

                                              <option value="ID">Idaho</option>

                                              <option value="IL">Illinois</option>

                                              <option value="IN">Indiana</option>

                                              <option value="IA">Iowa</option>

                                              <option value="KS">Kansas</option>

                                              <option value="KY">Kentucky</option>

                                              <option value="LA">Louisiana</option>

                                              <option value="ME">Maine</option>

                                              <option value="MD">Maryland</option>

                                              <option value="MA">Massachusetts</option>

                                              <option value="MI">Michigan</option>

                                              <option value="MN">Minnesota</option>

                                              <option value="MS">Mississippi</option>

                                              <option value="MO">Missouri</option>

                                              <option value="MT">Montana</option>

                                              <option value="NE">Nebraska</option>

                                              <option value="NV">Nevada</option>

                                              <option value="NH">New Hampshire</option>

                                              <option value="NJ">New Jersey</option>

                                              <option value="NM">New Mexico</option>

                                              <option value="NY">New York</option>

                                              <option value="NC">North Carolina</option>

                                              <option value="ND">North Dakota</option>

                                              <option value="OH">Ohio</option>

                                              <option value="OK">Oklahoma</option>

                                              <option value="OR">Oregon</option>

                                              <option value="PA">Pennsylvania</option>

                                              <option value="RI">Rhode Island</option>

                                              <option value="SC">South Carolina</option>

                                              <option value="SD">South Dakota</option>

                                              <option value="TN">Tennessee</option>

                                              <option value="TX">Texas</option>

                                              <option value="UT">Utah</option>

                                              <option value="VT">Vermont</option>

                                              <option value="VA">Virginia</option>

                                              <option value="WA">Washington</option>

                                              <option value="WV">West Virginia</option>

                                              <option value="WI">Wisconsin</option>

                                              <option value="WY">Wyoming</option>

                         



                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">

                                 <input type="text" class="Inptfild" name="Email" placeholder="Email Address">

                            </div>

                            <div class="col-7 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                <div class="sub">                                   

                                    <input type="file" class="file" name="Condolences_file_name" />
                                    <span class="addbtn" id="file-name">Add Photo</span>

                                </div>

                            </div>

                            <div class="col-5 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 

                            <!--<input type="hidden" name="action" value="addCondolence"/>-->
                            <input type="hidden" name="action" value="checkIPAddress"/>

                            <input type="hidden" name="Status" value="n">                      

                            <input type="hidden" name="ObituariesId" value="<?php echo $resultdata[0]['ObituariesId'] ?>"/> 
                            <input type="hidden" name="ip_address" value="<?php echo $ip_address?>"/>  

                               

                                <input type="submit" class="btn" value="Send"/>                          

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            

        </section>

        <!-- EVD send_part -->

    </div>  

    <!-- END content_part-->    



    <!-- START footer_part -->

    <?php require_once('footer.php');?>

<!-- END wrapper -->

<script src="common/js/jquery.validate.js"></script> 

<script src="common/js/form_validation.js"></script> 



<style>



  #condolence-form label.error {

    margin-left: 10px;

    width: auto;

    display: inline;

    color:red;

  }

  

  </style>

<script type="text/javascript">

    window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 
       history.pushState(null, "", location.href.split("&")[0]);
    });

}, 4000);

</script>