<?php

require_once './admin/common/config/config.inc.php';

require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';

require_once SOURCE_ROOT.'common/classes/class.paging.php';

$objObituaries=Factory::getInstanceOf('Obituaries');

$objPaging=Factory::getInstanceOf('Paging');



/*paging*/

$recordPerPage=5;

$varPageStart = $objPaging->getPageStartLimit($_GET['page'],$recordPerPage);

$varLimit = $varPageStart.','.$recordPerPage;



$resultdata=$objObituaries->getObituariesDetails('','','',$varLimit);

$recode=$objObituaries->getTotalObituaries();



$totalRecord = $recode[0]['total_record']; 

//unset($employeeList);

$varNumberPages = $objPaging->calculateNumberofPages($totalRecord,$recordPerPage);

$count=0;





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

                            <?php /*?><img class="headImg" src="<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>" alt="" width="250" height="250"><?php */?>

                            

           <img src="<?php echo SITE_ROOT_URL?>/timthumb.php?src=<?php echo SITE_ROOT_URL?>admin/common/uploaded_files/obituaries/<?php echo $image ?>&amp;w=263&amp;h=263" alt=""/>

           

           

          

                        </div>

                        

                

                        

                        

                        

                    <?php } else{?>

                        <img class="headImg" src="common/images/placeholder.jpg" alt="" width="263" height="263">

                    <?php }?>

                    </div>

                    <div class="textt col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">

                        <div class="subtext">

                            <h2><?php echo $result['ObituariesName'];?></h2>
                            <span><?php echo $result['ObituariesLocation'];?></span> 
                            
                            
                            <?php if($result['ObtituariesDate']!='0000-00-00'){?>
                            <span><?php $date = new DateTime($result['ObtituariesDate']); echo date_format($date,"M d, Y");?></span><br><br>
                           <?php }?>

                            <p><?php echo html_entity_decode($result['Description']);?></p>

                            <a href="obituaries_details.php?cId=<?php echo $result['ObituariesId'];?>" class="more">Learn More <i class="fas fa-arrow-right"></i></a>

                        </div>

                    </div>

                </div>

            <?php } 

            }

            ?>

          <?php if($totalRecord>=5){?>

           <div class="pagination clear"><?php $objPaging->displayPaging($_GET['page'], $varNumberPages, $recordPerPage); ?></div>

          <?php }?> 









            </div>        

        </section>

        <!-- END obituaries_part --> 



    </div> 

    <!-- END content_part-->    



    <!-- START footer_part -->

    <?php require_once('footer.php');?>