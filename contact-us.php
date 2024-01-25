<?php //session_start();
 require_once './admin/common/config/config.inc.php';
require_once('header.php');?>

<!-- START content_part-->

    <div id="content_part">



        <!-- START contact_map -->

        <div class="contact_map">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2916.9543368334175!2d-78.96588868423699!3d43.02134830107463!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d36bdea370de87%3A0x91eb9316f3724b22!2sKaiser+Funeral+Home!5e0!3m2!1sen!2sin!4v1561556969319!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

        </div>

        <!-- END contact_map -->



        <!-- START contact_part -->
      <?php //print_r($_SESSION);echo "@@@".$_SESSION['ststus'];?>
        
        <section class="contact_part"> 

            <div class="container">
               <?php if($_GET['msg']=='Success'){ ?>
               <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-check-circle"></i>Your form has been successfully submitted!
                  </div>
                <?php unset($_GET['msg']);
              }  if($_GET['msg']=='failed'){ ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <i class="fa fa-times-circle"></i> Something is Wrong.Please Try again.!
                  </div>
           <?php unset($_GET['msg']); }?>


                <div class="row">                

                    <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">


                        <div class="text">

                            <h2>Contact Us</h2>

                            <p><i class="fas fa-map-marker-alt"></i> 1950 Whitehaven Road, P.O.Box 115 Grand Island, NY 14072</p>

                            <p><i class="far fa-clock"></i> Opening Hours Mon - Sun 9.00-19.00</p>

                           

                            <p><a href="tel:(716)-773-3433"><img src="common/images/ftrphon_icn.png" alt=""> <span>(716)-773-3433</span></a></p>

                            

                            <p><a href="mailto:Info@yoursite.com"><i class="far fa-envelope"></i> Info@yoursite.com</a></p>

                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">

                        <div class="text subtext"> 

                            <h2>Send Us a Message</h2>

                            <form name="contact-us" id="contact-us" method="post" action="common/email.php">

                                <div class="row">

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <input type="text" class="Inptfild" name="user_name" placeholder="Name*">

                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <input type="text" class="Inptfild" name="Email_id" placeholder="E-mail*">

                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                        <input type="text" class="Inptfild" name="subject" placeholder="Subject">

                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                        <textarea name="message" cols="40" rows="10" class="" placeholder="Message"></textarea>

                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                        <button type="submit" class="btn" value="">Send Message</button>

                                    </div>



                                </div>

                            </form>

                        </div>

                    </div>

                </div>



            </div>        

        </section>

        <!-- START contact_part -->



    </div>

    <!-- END content_part-->
    

    <?php require_once('footer.php');?>
    <script src="common/js/jquery.validate.js"></script> 
    <script src="common/js/form_validation.js"></script> 
    <script type="text/javascript">

    window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 
       history.pushState(null, "", location.href.split("?")[0]);
    });

}, 4000);

</script>