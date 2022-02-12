$(function() {
    // owl carousel script starts
    if ($("#main-banner-carousel").length) {
      $("#main-banner-carousel").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 2000,
        autoplayHoverPause: true,
        autoWidth: false,
        dots: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1
          },
          320: {
            items: 1
          }
        }
      });
    }
  });
  
  
  $(function(){
    $(".caro-owl").owlCarousel({
      responsiveClass:true,
      loop:true,
      dots: false,
      autoplay: true,
      autoplaySpeed: 2000,
      smartSpeed: 2000,
      responsive:{
          0:{
              items:1,  
          },
          600:{
              items:2,   
          },
          1000:{
              items:3,
          }
      }
    });
    

     $(".next").on('click', function(){
      $(".caro-owl").trigger('next.owl.carousel');
    })
    $(".prev").on('click', function(){
      $(".caro-owl").trigger('prev.owl.carousel');
    })
  
  });

  $(function(){
    $("#news-flash").owlCarousel({
      responsiveClass:true,
      loop:true,
      dots: false,
      autoplay: true,
      autoplaySpeed: 1000,
      smartSpeed: 1000,
      responsive:{
          0:{
              items:1,  
          },
          600:{
              items:1,   
          },
          1000:{
              items:1,
          }
      }
    });
  });
  

        $("#inpt_search").on('focus', function () {
        $(this).parent('label').addClass('active');
        $("#inpt_search").attr('placeholder','Search here.....');
      });
  
      $("#inpt_search").on('blur', function () {
        if($(this).val().length == 0)
          $(this).parent('label').removeClass('active');
          $("#inpt_search").removeAttr('placeholder');
      });