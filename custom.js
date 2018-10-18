/* -----------------------------------------------

/* How to use? : Check the GitHub README

/* ----------------------------------------------- */



/* To load a config file (particles.json) you need to host this demo (MAMP/WAMP/local)... */

/*

particlesJS.load('particles-js', 'particles.json', function() {

  console.log('particles.js loaded - callback');

});

*/



/* Otherwise just put the config content (json): */

// Animations initialization



particlesJS('particles-js',

  

  {

    "particles": {

      "number": {

        "value": 80,

        "density": {

          "enable": true,

          "value_area": 800

        }

      },

      "color": {

        "value": "#ffffff"

      },

      "shape": {

        "type": "circle",

        "stroke": {

          "width": 0,

          "color": "#000000"

        },

        "polygon": {

          "nb_sides": 5

        },

        "image": {

          "src": "img/github.svg",

          "width": 100,

          "height": 100

        }

      },

      "opacity": {

        "value": 0.5,

        "random": false,

        "anim": {

          "enable": false,

          "speed": 1,

          "opacity_min": 0.1,

          "sync": false

        }

      },

      "size": {

        "value": 5,

        "random": true,

        "anim": {

          "enable": false,

          "speed": 40,

          "size_min": 0.1,

          "sync": false

        }

      },

      "line_linked": {

        "enable": true,

        "distance": 150,

        "color": "#ffffff",

        "opacity": 0.4,

        "width": 1

      },

      "move": {

        "enable": true,

        "speed": 6,

        "direction": "none",

        "random": false,

        "straight": false,

        "out_mode": "out",

        "attract": {

          "enable": false,

          "rotateX": 600,

          "rotateY": 1200

        }

      }

    },

    "interactivity": {

      "detect_on": "canvas",

      "events": {

        "onhover": {

          "enable": true,

          "mode": "repulse"

        },

        "onclick": {

          "enable": true,

          "mode": "push"

        },

        "resize": true

      },

      "modes": {

        "grab": {

          "distance": 400,

          "line_linked": {

            "opacity": 1

          }

        },

        "bubble": {

          "distance": 400,

          "size": 40,

          "duration": 2,

          "opacity": 8,

          "speed": 3

        },

        "repulse": {

          "distance": 200

        },

        "push": {

          "particles_nb": 4

        },

        "remove": {

          "particles_nb": 2

        }

      }

    },

    "retina_detect": true,

    "config_demo": {

      "hide_card": false,

      "background_color": "#b61924",

      "background_image": "",

      "background_position": "50% 50%",

      "background_repeat": "no-repeat",

      "background_size": "cover"

    }

  }



);



var tooltipNum2 = ['#Alamaba', '#Arkansas', '#Arizona', '#California', '#Colorado', '#Connecticut', '#Washington', '#Delaware', '#Florida', '#Georgia', '#Iowa', '#Hawaii', '#IdahoID', '#IdahoIL', '#Indiana', '#Kansas', '#Kentucky', '#Louisiana', '#Massachusetts', '#Maryland', '#Maine', '#Michigan', '#Minnesota', '#Missouri', '#Mississippi', '#Montana', 

'#NorthCarolina', '#NorthDakota', '#Nebraska', '#NewHampshire', '#NewJersey', '#NewMexico', '#Nevada', '#NewYork', '#Ohio', '#Oklahoma', '#Oregon', '#Pennsylvania', '#RhodeIsland', '#SouthCarolina', '#SouthDakota', '#Tennessee', '#Texas', '#Utah', '#Virginia', '#Vermont', '#Washington1', '#Wisconsin', '#WestVirginia', '#Wyoming']



jQuery(tooltipNum2).qtip({

  content: function() {

    return jQuery( this ).data('tooltip'); //store data in data-tooltip

    },

  position: {

    my: 'bottom center',  // Position my top left...

    at: 'top center', // at the bottom right of...

    adjust: {

            y: 0

        }

  },

  style: {

    tip: {

    corner: true,

    border: 1,

    width: 15,

    height: 7

    }

  }

});





jQuery(document).ready(function($) {



    $('a[href^="#"]').bind('click.smoothscroll', function(e) {

        e.preventDefault();

        

        // Get the current target hash

        var target = this.hash;

       

        // Animate the scroll bar action so its smooth instead of a hard jump

        $('html, body').stop().animate({

          //var topOffset = 0; //#top should default to 0 so no need to calculate the difference between top and top :)



'scrollTop' : $(target).offset().top

           // 'scrollTop' : $(target).offset().top 

        }, 900, 'swing', function() {

            window.location.hash = target;

        });

  

    });







    // Hide the loader and show the elements.

    setTimeout(function () {

      $('.loader').addClass('hidden').delay(200).remove();

    }, 1900);

  

var scrollTop = $(".scrollupEflyer");



  $(window).scroll(function() {

    // declare variable

    var topPos = $(this).scrollTop();



    // if user scrolls down - show scroll to top button

    if (topPos > 100) {

      $(scrollTop).css("opacity", "1");



    } else {

      $(scrollTop).css("opacity", "0");

    }



  }); // scroll END



  //Click event to scroll to top

  $(scrollTop).click(function() {

    $('html, body').animate({

      scrollTop: 0

    }, 800);

    return false;



  }); // click() scroll top EMD





  //Click event to scroll to top



});



/* global wc_add_to_cart_params */

jQuery(document).ready(function($){



  if ( typeof wc_add_to_cart_params === 'undefined' ) {

    return false;

  }



  /**

   * AddToCartHandler class.

   */

  var AddToCartHandler = function() {

    $( document.body )

      .on( 'click', '.add_to_cart_button', this.onAddToCart )

      .on( 'click', '.remove_from_cart_button', this.onRemoveFromCart )

      .on( 'added_to_cart', this.updateButton )

      .on( 'added_to_cart', this.updateCartPage )

      .on( 'added_to_cart removed_from_cart', this.updateFragments );

  };



  /**

   * Handle the add to cart event.

   */

  AddToCartHandler.prototype.onAddToCart = function( e ) {

    var $thisbutton = $( this );



    if ( $thisbutton.is( '.ajax_add_to_cart' ) ) {

      if ( ! $thisbutton.attr( 'data-product_id' ) ) {

        return true;

      }



      e.preventDefault();



      $thisbutton.removeClass( 'added' );

      $thisbutton.addClass( 'loading' );



      var data = {};



      $.each( $thisbutton.data(), function( key, value ) {

        data[ key ] = value;

      });



      // Trigger event.

      $( document.body ).trigger( 'adding_to_cart', [ $thisbutton, data ] );



      // Ajax action.

      $.post( wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' ), data, function( response ) {

        if ( ! response ) {

          return;

        }



        if ( response.error && response.product_url ) {

          window.location = response.product_url;

          return;

        }



        // Redirect to cart option

        if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {

          window.location = wc_add_to_cart_params.cart_url;

          return;

        }



        // Trigger event so themes can refresh other areas.

        $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );

      });

    }

  };



  /**

   * Update fragments after remove from cart event in mini-cart.

   */

  AddToCartHandler.prototype.onRemoveFromCart = function( e ) {

    var $thisbutton = $( this ),

      $row        = $thisbutton.closest( '.woocommerce-mini-cart-item' );



    e.preventDefault();



    $row.block({

      message: null,

      overlayCSS: {

        opacity: 0.6

      }

    });



    $.post( wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'remove_from_cart' ), { cart_item_key : $thisbutton.data( 'cart_item_key' ) }, function( response ) {

      if ( ! response || ! response.fragments ) {

        window.location = $thisbutton.attr( 'href' );

        return;

      }

      $( document.body ).trigger( 'removed_from_cart', [ response.fragments, response.cart_hash ] );

    }).fail( function() {

      window.location = $thisbutton.attr( 'href' );

      return;

    });

  };



  /**

   * Update cart page elements after add to cart events.

   */

  AddToCartHandler.prototype.updateButton = function( e, fragments, cart_hash, $button ) {

    $button = typeof $button === 'undefined' ? false : $button;



    if ( $button ) {

      $button.removeClass( 'loading' );

      $button.addClass( 'added' );



      // View cart text.

      if ( ! wc_add_to_cart_params.is_cart && $button.parent().find( '.added_to_cart' ).length === 0 ) {

        $button.after( ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +

          wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' );

      }



      $( document.body ).trigger( 'wc_cart_button_updated', [ $button ] );

    }

  };



  /**

   * Update cart page elements after add to cart events.

   */

  AddToCartHandler.prototype.updateCartPage = function() {

    var page = window.location.toString().replace( 'add-to-cart', 'added-to-cart' );



    $( '.shop_table.cart' ).load( page + ' .shop_table.cart:eq(0) > *', function() {

      $( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

      $( document.body ).trigger( 'cart_page_refreshed' );

    });



    $( '.cart_totals' ).load( page + ' .cart_totals:eq(0) > *', function() {

      $( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();

      $( document.body ).trigger( 'cart_totals_refreshed' );

    });

  };



  /**

   * Update fragments after add to cart events.

   */

  AddToCartHandler.prototype.updateFragments = function( e, fragments ) {

    if ( fragments ) {

      $.each( fragments, function( key ) {

        $( key )

          .addClass( 'updating' )

          .fadeTo( '400', '0.6' )

          .block({

            message: null,

            overlayCSS: {

              opacity: 0.6

            }

          });

      });



      $.each( fragments, function( key, value ) {

        $( key ).replaceWith( value );

        $( key ).stop( true ).css( 'opacity', '1' ).unblock();

      });



      $( document.body ).trigger( 'wc_fragments_loaded' );

    }

  };



  /**

   * Init AddToCartHandler.

   */

  new AddToCartHandler();

});

jQuery(document).ready(function($) {
 function setClasses(index, steps) {
    if (index < 0 || index > steps) return;
    if(index == 0) {
      $("#prev").prop('disabled', true);
      $("#step1Form").css('display', 'inline-flex');
    } else {
      $("#prev").prop('disabled', false);
      $("#step1Form").css('display', 'none');
    }
    if(index == 1) {
    $("#step2Form").css('display', 'block');

    } else {
    $("#step2Form").css('display', 'none');
    }
    if(index == 2) {
    $("#step3Form").css('display', 'block');

    } else {
    $("#step3Form").css('display', 'none');
    }
    if(index == 3) {
       $("#step4Form").css('display', 'block');
      $("#next").prop('disabled', true);
      //$("#next").text('done');
    } else {
      $("#next").prop('disabled', false);
      $("#next").text('next');
      $("#step4Form").css('display', 'none');
    }
    $(".step-wizard ul li").each(function() {
      $(this).removeClass();
    });
    $(".step-wizard ul li:lt(" + index + ")").each(function() {
      $(this).addClass("done");
    });
    $(".step-wizard ul li:eq(" + index + ")").addClass("active")
    var p = index * (100 / steps);
    $("#prog").width(p + '%');
  }
  $(".step-wizard ul a").click(function() {
    var step = $(this).find("span.step")[0].innerText;
    var steps = $(".step-wizard ul li").length;
    setClasses(step - 1, steps - 1)
  });
  $("#prev").click(function(){
     $(window).scrollTop(0);
    var step = $(".step-wizard ul li.active span.step")[0].innerText;
    var steps = $(".step-wizard ul li").length;    
    setClasses(step - 2, steps - 1);
  });
  $("#next").click(function(){
     $(window).scrollTop(0);
    if ($(this).text() == 'done') {
      alert("submit the form?!?")
    } else {
      var step = $(".step-wizard ul li.active span.step")[0].innerText;
      var steps = $(".step-wizard ul li").length; 
          var isValid = jQuery("#validationForm").valid(); 
        if(!isValid) {
                e.preventDefault(); 
                }
                else {
                       setClasses(step, steps - 1); 
                }    

    }
  });
  
  // initial state setup
  setClasses(0, $(".step-wizard ul li").length);
});

jQuery('textarea').keydown(function(){



    if(this.value.length > 499){

        return false;

    }

    jQuery(".descriptionLetters").html((499 - this.value.length));

});


function bs_input_file() {
var fileExtension = ['gif', 'png', 'jpg', 'jpeg'];
	$('#inputUploudPhoto').change(function(){
var photo = $(this).val().split('\\').pop();
var checkExtension = $(this).val().split('.').pop().toLowerCase();
if($.inArray(checkExtension, fileExtension)  == -1) {
	$(this).val('');
	alert("Choose only image file!");
} else {
var label = $(this).siblings('label');
label.text(photo);
}


});
$('#inputUploudLogo').change(function(){
var fileExtensionLogo = ['png'];
var photo = $(this).val().split('\\').pop();
var checkExtension = $(this).val().split('.').pop().toLowerCase();
if($.inArray(checkExtension, fileExtensionLogo)  == -1) {
	$(this).val('');
	alert("Choose only png file!");
} else {
var label = $(this).siblings('label');
label.text(photo);
}

});

$('#propertyImg').each(function() {
  $mainElement = $(this);
   $mainElement.change(function(){
  var photo = $(this).val().split('\\').pop();
  var checkExtension = $(this).val().split('.').pop().toLowerCase();
  if($.inArray(checkExtension, fileExtension)  == -1) {
  $(this).val('');
  alert("Choose only image file!");
  } else {
  var label = $(this).siblings('label');
  label.text(photo);
  }
  });
   
  $sibling = $mainElement.closest('div').siblings('div').find('input');
  $sibling.change(function($mainElement){
var photo = $(this).val().split('\\').pop();
var checkExtension = $(this).val().split('.').pop().toLowerCase();
  if($.inArray(checkExtension, fileExtension)  == -1) {
  $(this).val('');
  alert("Choose only image file!");
  } else {
var label = $(this).siblings('label');
label.text(photo);
  }

  });

  
});


}

jQuery(document).ready(function(){
	bs_input_file();
});




	




                