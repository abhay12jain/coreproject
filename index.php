 <?php 
require_once './admin/common/config/config.inc.php';
require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';
$objObituaries=Factory::getInstanceOf('Obituaries');
$resultdata=$objObituaries->getCurrentObituaries();
?>

 <?php require_once('header.php');?>



 <!-- START content_part-->



    <div id="content_part">

        <!-- START banner_part -->

        <section class="banner_part">



            <div class="bannerslide">







                <div class="item" style="background-image: url(common/images/banner_slide01.JPG);">



                    <div class="container">



                        <div class="text">



                            <h2>Helping Families Connect,<span> Honor & Remember </span></h2>



                        </div>



                    </div>



                </div>



                <div class="item" style="background-image: url(common/images/banner_slide02.JPG);">



                    <div class="container">



                        <div class="text">



                            <h2>Helping Families Connect,<span> Honor & Remember </span></h2>



                        </div>



                    </div>



                </div>



                <div class="item" style="background-image: url(common/images/banner_slide03.JPG);">



                    <div class="container">



                        <div class="text">



                            <h2>Helping Families Connect,<span> Honor & Remember </span></h2>



                        </div>



                    </div>



                </div>







            </div>       



        </section>



        <!-- END banner_part -->







        <!-- START kaiser_part -->



        <section class="kaiser_part">



            <div class="container">







                <h3>Welcome To</h3>



                <h2>About Us</h2>



                <img src="common/images/headImg_02.png" alt="">



               <p> Kaiser Funeral Home has been serving the families of Grand Island and Western New York for over 60 years. Family owner and operated through three generations, we understand the needs and values of the community. We are dedicated to helping families, friends and neighbors through the difficult time of a loss of a loved one.
</p>



                <a href="about.php" class="more">More Info <i class="fas fa-arrow-right"></i></a>







            </div>       



        </section>



        <!-- END kaiser_part -->







        <!-- START current_part -->



        <section class="current_part">



            <div class="container">



                <h2>Current Obituaries</h2>







                <div class="currentText">

                    <?php foreach($resultdata as $result){



                       $image=$result['ObituariesFileName'];

                        ?>



                    <div class="itemBox">



                        <div class="subText column">



                            <h3 class="match title"><?php echo $result['ObituariesName']; ?></h3>



                            <span><?php $date = new DateTime($result['ObtituariesDate']); echo date_format($date,"M d, Y");?></span>



                            <p class="description match"><?php echo html_entity_decode(substr($result['Description'],0,100)).'......';?></p>



                            <a href="obituaries_details.php?cId=<?php echo $result['ObituariesId'];?>" class="more">Read More <i class="fas fa-arrow-right"></i></a>



                        </div>



                        <?php if($image){ ?>



                        <div class="image"> 

          <?php /*?><img src="<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>" alt=""><?php */?>

                        

                        <img src="<?php echo SITE_ROOT_URL?>/timthumb.php?src=<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>&amp;w=216&amp;h=299" alt=""/>

                        

                        

                        </div>



                        <?php } else{?>

                           <div class="image"> <img src="common/images/placeholder.jpg" width="263" height="263" alt="" >

                        </div>





                     <?php }?>

                   



                    </div>

                    <?php }?>

                    

                </div>







                <div class="viewall">



                    <a href="<?php echo SITE_ROOT_URL?>obituaries.php">View All Obituaries</a>



                </div>



            </div>



        </section>



        <!-- END current_part -->



        



    </div>



    <!-- END content_part-->







    <!-- START footer_part -->



     <?php require_once('footer.php');?>

   
