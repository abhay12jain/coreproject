 <footer class="footer_part">

<div class="bottom_stick">
        <a class="left" href="tel:7167733433">Click To Call 716-773-3433</a>
        <a href="obituaries.php"  class="right">View Obituaries</a>
    </div>

        <div class="footerBox">

            <div class="container">



                <div class="row">

                    <div class="sub col-12 col-sm-12 col-md-4 col-lg-5 col-xl-5">

                        <div class="subtext">

                            <a href="index.html"><img src="common/images/ftrlogo.png" alt=""></a>

                            <p >Lorem ipsum dolor sit amet, consectetur adipi scing elit, sed do labore et dolore magna aliqua. </p>

                            <ul class="socialIcon">

                                

                                <li><a target="_blank" href="#"><i class="fab fa-twitter"></i></a></li>

                                <li><a target="_blank" href="#"><i class="fab fa-facebook-f"></i></a></li>                

                                <li><a target="_blank" href="#"><i class="fab fa-google-plus-g"></i></a></li>

                                <li><a target="_blank" href="#"><i class="fab fa-linkedin-in"></i></a></li>

                       

                            </ul>

                        </div>

                    </div>

                    <div class="sub2 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">

                        <div class="item">

                            <h2>Quick Links</h2>

                            <ul class="link">

                                <li><a href="#">Resources For Those In Grief</a></li>

                                <li><a href="#">psychology articles</a></li>

                                <li><a href="#">Memorials & Obituaries</a></li>

                                <li><a href="#">Meke A Donation</a></li>

                            </ul>

                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">

                        <div class="item">

                            <h2>Our Contacts</h2>

                            <p><a href="mailto:Info@yoursite.com"><i class="fa fa-envelope"></i> Info@yoursite.com</a></p>

                            <p><a href="tel:(716)-773-3433"><img src="common/images/ftrphon_icn.png" alt=""><span>(716)-773-3433</span></a></p>

                            <p><i class="fas fa-map-marker-alt"></i> 1950 Whitehaven Road, P.O.Box 115 Grand Island, NY 14072</p>

                        </div>

                    </div>

                </div>



            </div>

        </div>



        <div class="copyright">

            <div class="container">

                <p> &copy; 2019 All rights reserved. </p>

            </div>

        </div>

       

    </footer>

    <!-- END footer_part -->

    

</section>

<!-- END wrapper -->



<script src="common/js/3.2.1.min.js"></script> 

<script src="common/js/jquery.mmenu.min.all.js"></script> 

<script src="common/js/bootstrap.min.js"></script> 

<script src="common/js/slick.min.js"></script>

<script src="common/js/custom.js"></script> 

<script type="text/javascript">





//var selector = '#menu ul li';

   $(function() {

     var pgurl = window.location.href.substr(window.location.href

.lastIndexOf("/")+1);

//alert(pgurl);

     $("#menu ul li a").each(function(){

          if($(this).attr("href") == pgurl || $(this).attr("href") == '' )

          $(this).addClass("active");

     })

});

		



</script>



</body>

</html>

