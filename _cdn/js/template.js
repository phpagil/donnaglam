//[Master Javascript]

//Project:	Cosmetic Agency Html Responsive Template
//Version:	1.1
//Last change:	01/06/2017
//Primary use:	Cosmetic Agency Html Responsive Template

jQuery(function ($) {
  'use strict';
  $(window).load(function () {
    // Animate loader off screen
    $('.loader').fadeOut('slow');
  });

  // Masterslider
  var slider = new MasterSlider();
  slider.setup('masterslider', {
    width: 1024,
    height: 580,
    //space:100,
    fullwidth: true,
    centerControls: false,
    speed: 18,
    view: 'flow',
    overPause: false,
    autoplay: false,
  });
  //slider.control('arrows');
  slider.control('bullets', { autohide: false });

  // Masterslider shop
  var slider = new MasterSlider();

  slider.control('arrows');
  //   slider.control('thumblist', {
  //     autohide: true,
  //     dir: 'h',
  //     arrows: true,
  //     align: 'bottom',
  //     width: 127,
  //     height: 137,
  //     margin: 5,
  //     space: 5,
  //   });
  // TODO: RETORNAR A THUMBNAIL QUANDO O SISTEMA PERMITIR VARIAS IMAGENS POR PRODUTO

  slider.setup('masterslidershop', {
    width: 540,
    height: 586,
    space: 5,
    view: 'scale',
  });

  // Portfolio and blog slider

  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 15,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        items: 3,
        nav: false,
      },
      1000: {
        items: 4,
        nav: true,
        dots: false,
      },
    },
  });

  //Coundown
  $('.demo2').dsCountDown({
    endDate: new Date('October 2, 2017 23:59:00'),
    theme: 'black',
  });
}); // End of use strict
