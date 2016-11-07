/**
 * @file
 * Provides responsive menu toggle and dropdown functionality.
 */

(function ($) {
  Drupal.behaviors.responsiveDropdownMenuToggle = {
    attach: function(context, settings) {

      var responsiveDropdownMenus = Drupal.settings.responsive_dropdown_menus;
      var menuToggleHelper = Drupal.t('Menu');

      // Cycle through responsive dropdown menu blocks.
      $('.responsive-menu', context).each(function(index) {
        var menuID = $(this).attr('id');

        // Check if delta equals the element's ID.
        $.each(responsiveDropdownMenus, function(delta, title) {
          if(delta == menuID) {
            menuToggleHelper = title;
          }
        });
        if(!$(this).prev().hasClass('menu-toggle')) {
          // Drop in our menu toggle.
          var title = Drupal.t('Toggle Menu');
          $(this).before('<a class="menu-toggle" title="' + title + '"><span class="line first-line first"></span><span class="line"></span><span class="line last-line last"></span><span class="toggle-help">' + menuToggleHelper + '</span></a>');
        }
      });

      // Bind click event to toggle.
      $('.menu-toggle').click(function(){
        $(this).next().toggleClass('menu-toggled');
      });
    }
  };

  Drupal.behaviors.responsiveDropdownMenuDropDown = {
    attach: function(context) {
      $('.responsive-menu li.menu-parent').hover(
        function() {
          $(this).find('.sub-menu').addClass('active');
        },
        function() {
          $(this).find('.sub-menu').removeClass('active');
        }
      );
    }
  }
})(jQuery);
;
(function ($) {
	Drupal.behaviors.backtotop = {
		attach: function(context) {
			var exist= jQuery('#backtotop').length;
      if(exist == 0) {
        $("body", context).once(function() {
          $(this).append("<div id='backtotop'>"+Drupal.t(Drupal.settings.back_to_top.back_to_top_button_text)+"</div>");
        });
      }
			$(window).scroll(function() {
				if($(this).scrollTop() > Drupal.settings.back_to_top.back_to_top_button_trigger) {
					$('#backtotop').fadeIn();	
				} else {
					$('#backtotop').fadeOut();
				}
			});

      $('#backtotop', context).once(function() {
			  $(this).click(function() {
			    $("html, body").bind("scroll mousedown DOMMouseScroll mousewheel keyup", function() {
            $('html, body').stop();
          });
          $('html,body').animate({ scrollTop: 0 }, 1200, 'easeOutQuart', function() {
            $("html, body").unbind("scroll mousedown DOMMouseScroll mousewheel keyup");
          });
          return false;
			  });
			});
		}
	};
})(jQuery);;
