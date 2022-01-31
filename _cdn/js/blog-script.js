//[Master Javascript]

//Project:	Cosmetic Agency Html Responsive Template
//Version:	1.1
//Last change:	01/06/2017
//Primary use:	Cosmetic Agency Html Responsive Template 



jQuery(function ($) {
    "use strict";
 	$(window).load(function () {
        // Animate loader off screen
        $(".loader").fadeOut("slow");
    });
	
// widgetClientTestimonial on blog page widget
 	$('.widgetClientTestimonial').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            directionNav: false
        });
	
});// End of use strict