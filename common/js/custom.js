$(function() {
	$('#menu').mmenu({		
		clone: false,

         "extensions": [
            "position-right"
               ]		
	});

});

$(window).scroll(function() {
    if($(window).width()>1024){ 
    
    if ($(this).scrollTop() > 150){  
        $('header').addClass("stickyhead");
		//$('.footer_part .bottom_stick').fadeIn()
      }
      else{
        $('header').removeClass("stickyhead");
		//$('.footer_part .bottom_stick').fadeOut();
      }
  }
});


$(window).scroll(function() {
    //if($(window).width()>1024){ 
    
    if ($(this).scrollTop() > 150){  
        //$('header').addClass("stickyhead");
		//$('.footer_part .bottom_stick').fadeIn()
      }
      else{
       // $('header').removeClass("stickyhead");
		//$('.footer_part .bottom_stick').fadeOut();
      }
  //}
});



if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 500);
    });
}

$('.bannerslide').slick({
  infinite: true,
  slidesToShow: 1,
  autoplay:true,
  autoplaySpeed:8000,
  dots: true,
  arrows: false,
  slidesToScroll: 1
});
$('input[type="file"]').change(function(e){
	var fileName = e.target.files[0].name;
	$('#file-name').text(fileName);
});




