/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

    jQuery(function () {
        jQuery('input,textarea').focus(function () {
        jQuery(this).data('placeholder', jQuery(this).attr('placeholder')).attr('placeholder', '');
        }).blur(function () {
            jQuery(this).attr('placeholder', jQuery(this).data('placeholder'));
        });
    });

      jQuery('.showRight a').attr('id', 'showRight');

      var menuLeft = document.getElementById( 'cbp-spmenu-s1' );
            var showRight = document.getElementById( 'showRight' );
            body = document.body;

        showRight.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( menuLeft, 'cbp-spmenu-open' );
        };

        jQuery(".spe-close").click(function() {

            if (jQuery( "#cbp-spmenu-s1" ).hasClass( "cbp-spmenu-open" )) {
                jQuery( "#cbp-spmenu-s1" ).removeClass( "cbp-spmenu-open" );
            }
        });


        jQuery( ".login-submit" ).click(function() {
            jQuery( ".login-error" ).empty();
        });

        jQuery( ".reg-submit" ).click(function() {
            jQuery( ".login-error" ).empty();
        });

        jQuery( ".pro-submit" ).click(function() {
            jQuery( ".login-error" ).empty();
        });

        // Login Validation

        jQuery("#form-login").validate({

            rules: {

                username: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },
            },

            // Specify the validation error messages
            messages: {

                username: "Please enter a valid email address",
                password: "Please provide a password",

            },

            submitHandler: function(form, event) {

                event.preventDefault();

                jQuery( ".ajax-loader" ).show();

                jQuery.ajax({

                    url: ajaxurl,
                    type: "POST",
                    data: {
                        'action'    : 'user_login_request',
                        'username'  : jQuery(".login-username").val(),
                        'password'  : jQuery(".login-pass").val(),
                    },

                    success:function(data) {
                        // This outputs the result of the ajax request
                        jQuery( ".ajax-loader" ).hide();

                        if (data === 'Error') {
                            jQuery( ".login-error" ).append( 'Invalid Username / Password' );
                        } else {
                            window.location.href = data;
                        }

                    },

                    error: function(errorThrown){
                        console.log(errorThrown);
                    }

                });

            }

        });

        // Lost password

        jQuery("#form-lost").validate({

            rules: {

                email: {
                    required: true,
                    email: true
                },
            },

            // Specify the validation error messages
            messages: {

                username: "Please enter a valid email address",

            },

            submitHandler: function(form, event) {

                event.preventDefault();

                jQuery( ".ajax-loader" ).show();

                jQuery.ajax({

                    url: ajaxurl,
                    type: "POST",
                    data: {
                        'action'    : 'user_lostpass_request',
                        'email'  : jQuery(".lost-email").val(),
                    },

                    success:function(data) {
                        // This outputs the result of the ajax request
                        jQuery( ".ajax-loader" ).hide();

                        alert (data);

                        if (data === 'Invalid') {

                            jQuery( ".login-error" ).append( "Email ID dosen't exist.");

                        } else {
                           jQuery( ".login-error" ).append( '<div class="success">Check your email for the password.</div>');
                        }

                    },

                    error: function(errorThrown){
                        console.log(errorThrown);
                    }

                });

            }

        });

        // Registration Validation

        jQuery("#form-reg").validate({

            rules: {

                firstname : {
                    required: true,
                },

                speciality: {
                    required: true,
                },

                phone: {
                    number: true,
                },

                email: {
                    required: true,
                    email: true
                },

                pass: {
                    required: true,
                    minlength: 5,
                },

                confirmpass: {
                    equalTo: ".reg-pass"
                }
            },

            // Specify the validation error messages
            messages: {

                firstname: "Enter your name",
                email: "Invalid email address",
                speciality: "Select your Speciality",
                pass: {
                    required: "Provide a password",
                    minlength: "Password must be min 5 characters"
                },
                confirmpass: "Password not matching",
                phone: "Invalid phone number"

            },

            submitHandler: function(form, event) {

                event.preventDefault();

                jQuery( ".ajax-loader" ).show();

                jQuery.ajax({

                    url: ajaxurl,
                    type: "POST",
                    data: {
                        'action'        : 'user_register_request',
                        'firstname'     : jQuery(".reg-firstname").val(),
                        'lastname'      : jQuery(".reg-lastname").val(),
                        'email'         : jQuery(".reg-email").val(),
                        'phone'         : jQuery(".reg-phone").val(),
                        'password'      : jQuery(".reg-pass").val(),
                        'speciality'    : jQuery( ".reg-speciality option:selected" ).text(),
                    },

                    success:function(data) {

                        // This outputs the result of the ajax request
                        jQuery( ".ajax-loader" ).hide();

                        if (data === 'Error') {
                            jQuery( ".login-error" ).append( 'Error occured. Please try again.' );
                        } else if (data === 'Exist') {
                            jQuery( ".login-error" ).append( 'Sorry, that username already exists!' );
                        } else {
                            window.location.href = data;
                        }
                    },

                    error: function(errorThrown){
                        console.log(errorThrown);
                    }

                });

            }

        });

        // Profile Validation

        jQuery("#form-profile").validate({

            rules: {

                firstname : {
                    required: true,
                },

                speciality: {
                    required: true,
                },

                phone: {
                    number: true,
                },

                pass: {
                    minlength: 5
                },

                confirmpass: {
                    equalTo: ".pro-pass"
                }
            },

            // Specify the validation error messages
            messages: {

                firstname: "Enter your name",
                speciality: "Select your Speciality",
                pass: {
                    minlength: "Password must be min 5 characters"
                },
                confirmpass: "Password not matching",
                phone: "Invalid phone number"

            },

            submitHandler: function(form, event) {

                event.preventDefault();

                jQuery( ".ajax-loader" ).show();

                jQuery.ajax({

                    url: ajaxurl,
                    type: "POST",
                    data: {
                        'action'        : 'user_profile_update_request',
                        'firstname'     : jQuery(".pro-firstname").val(),
                        'lastname'      : jQuery(".pro-lastname").val(),
                        'phone'         : jQuery(".pro-phone").val(),
                        'password'      : jQuery(".pro-pass").val(),
                        'speciality'    : jQuery(".pro-speciality option:selected" ).text(),
                    },

                    success:function(data) {

                        // This outputs the result of the ajax request
                        jQuery( ".ajax-loader" ).hide();

                        if (data === 'Error') {
                            jQuery( ".login-error" ).append( 'Error occured. Please try again.' );
                        } else {
                            jQuery( ".login-error" ).append( 'Profile Updated Successfully' );
                        }
                    },

                    error: function(errorThrown){
                        console.log(errorThrown);
                    }

                });

            }

        });

        jQuery( 'p:empty' ).remove();

        jQuery(".icon-search").click(function(){
            jQuery(".search-wrap").fadeToggle(300);
        });

        jQuery(".search-wrap .overlay").click(function(){
            jQuery(".search-wrap").fadeToggle(300);
        });

        jQuery('.home-slider').slick({

            dots: true,
            infinite: true,
            speed: 900,
            slidesToShow: 5,
            slidesToScroll: 5,

            responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,
              }
            },
            {
              breakpoint: 600,
              settings: {
                dots: false,
                slidesToShow: 2,
                slidesToScroll: 2,
              }
            },
            {
              breakpoint: 480,
              settings: {
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        // Slider Arrow Position On Scroll

        jQuery(".slick-slide img").load(function(){

            $sliderImg = jQuery( '.slick-slide img' ).height();

            $arrowTop = ($sliderImg/2) + 'px';

            jQuery('.home-slider .slick-prev').css('top', $arrowTop);

            jQuery('.home-slider .slick-next').css('top', $arrowTop);

        });


        jQuery(window).resize(function () {

            $sliderImg = jQuery( '.slick-slide img' ).height();

            $arrowTop = ($sliderImg/2) + 'px';

            jQuery('.home-slider .slick-prev').css('top', $arrowTop);

            jQuery('.home-slider .slick-next').css('top', $arrowTop);

        });

        // jQuery Window Scroll Load Post

        $status = '0';
        $page = '1';

        // Get URL Parameter

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        if ( ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) || (jQuery(window).width() < 768) ) {

        } else {

            jQuery(window).scroll(function() {

                if(jQuery(window).scrollTop() + jQuery(window).height() > jQuery(document).height() - 100) {

                    if (getUrlParameter('cat')) {

                        if ( $status === '0') {

                            jQuery( ".ajax-loader" ).show();

                            $status = '1';

                            jQuery.ajax({

                            url: ajaxurl,
                            type: 'POST',
                            data: {
                              'action'  : 'load_post_onscroll',
                              'type'    : getUrlParameter('type'),
                              'media'   : getUrlParameter('media'),
                              'cat'     : getUrlParameter('cat'),
                              'page'    : $page
                            },

                                success:function(data) {

                                    if (data === "0") {

                                        $status = '1';

                                        jQuery( ".ajax-loader" ).hide();

                                        } else if (data === '1') {

                                            jQuery( ".ajax-load .row" ).append(function() {

                                                return '<div class="hidden-xs hidden-sm clearfix"></div><div class="col-xs-12"><div class="post-end">You have reached the end.</div></div>';

                                        });

                                            $status = '1';

                                            jQuery( ".ajax-loader" ).hide();

                                        } else {

                                            $page++;

                                            $status = '0';

                                            jQuery( ".ajax-loader" ).hide();

                                            jQuery( ".col-md-8 .row" ).append(function() {

                                            return data;

                                            });
                                        }
                                    },

                                error: function(errorThrown){
                                  console.log(errorThrown);
                              }

                            });

                        }

                    }

                }

            });

        }

        jQuery(".load-more").click(function() {

            jQuery('.load-more').remove();

            if (getUrlParameter('cat')) {

                if ( $status === '0') {

                    jQuery( ".ajax-loader" ).show();

                      $status = '1';

                      jQuery.ajax({

                      url: ajaxurl,
                      type: 'POST',
                      data: {
                          'action'  : 'load_post_onscroll',
                          'type'    : getUrlParameter('type'),
                          'media'   : getUrlParameter('media'),
                          'cat'     : getUrlParameter('cat'),
                          'page'    : $page
                      },

                      success:function(data) {

                          if (data === "0") {

                              jQuery( ".load-more" ).remove();

                              $status = '1';

                              jQuery( ".ajax-loader" ).hide();

                          } else if (data === "1") {

                              jQuery( ".load-more" ).remove();

                              jQuery( ".ajax-load .row" ).append(function() {

                                  return '<div class="hidden-xs hidden-sm clearfix"></div><div class="col-xs-12"><div class="post-end">You have reached the end.</div></div>';

                              });

                              $status = '1';

                              jQuery( ".ajax-loader" ).hide();

                          } else {

                              $status = '0';

                              $page++;

                              jQuery( ".ajax-loader" ).hide();

                              jQuery( ".col-md-8 .row" ).append(function() {

                                return data;

                              });
                          }

                          jQuery('.load-more').attr("disabled", false);
                      },

                      error: function(errorThrown){
                          console.log(errorThrown);
                      }

                  });

                }
            }

        });
    },

      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
