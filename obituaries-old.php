<?php

require_once './admin/common/config/config.inc.php';

require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';

$objObituaries=Factory::getInstanceOf('Obituaries');

$resultdata=$objObituaries->getObituaries();

?>

<?php require_once('header.php');?>

    <!-- END header_part -->



    <!-- START content_part-->

    <div id="content_part">



        <!-- START innerbanner -->

        <div class="innerbanner" style="background-image: url(common/images/aboutbnr.jpg);">

            <div class="overlay">

                <div class="container">

                    <h1>Obituaries </h1>

                </div>

            </div>

        </div>

        <!-- END innerbanner -->



        <!-- START obituaries_part -->

        <section class="obituaries_part">

            <div class="container">



            <?php  

                if($resultdata) { foreach($resultdata as $result){

                    $image=$result['ObituariesFileName'];

                 //print_r($result);

            ?>

                

                <div class="row itembox">

                    <div class="text col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">

                        <?php if($image){?>

                        <div class="image">

                            <!--<img src="common/images/obituImg01.jpg" alt="">-->

                            <img class="headImg" src="<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>" alt="" width="250" height="250">

                        </div>

                    <?php } else{?>

                        <img class="headImg" src="common/images/placeholder.jpg" alt="" width="250" height="250">

                    <?php }?>

                    </div>

                    <div class="textt col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">

                        <div class="subtext">

                            <h2><?php echo $result['ObituariesName'];?></h2>

                            <span><?php $date = new DateTime($result['AddedDate']); echo date_format($date,"M d, Y");?></span><br><br>

                            <?php echo html_entity_decode(substr($result['Description'],0,200));?>

                            <a href="obituaries_details.php?cId=<?php echo $result['ObituariesId'];?>" class="more">Learn More <img src="common/images/righ_arrow2.png" alt=""></a>

                        </div>

                    </div>

                </div>

            <?php } 

            }

            ?>





            </div>        

        </section>

        <!-- END obituaries_part --> 



    </div> 

    <!-- END content_part-->    



    <!-- START footer_part -->

    <?php require_once('footer.php');?>