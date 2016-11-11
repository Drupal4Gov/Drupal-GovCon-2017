(function($) {

Drupal.behaviors.moduleFilterDynamicPosition = {
  attach: function(context) {
    var $window = $(window);
    
    $(".messages").prependTo("#user-login");
    $(".alert").prependTo("#user-login");
    $('#edit-pass').keypress(function(e) {
      var s = String.fromCharCode( e.which );
      if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
        
        $('#capslockdiv p').show();
      }
      else {
        $('#capslockdiv p').hide();
      }
    });
  
  }
};

})(jQuery);;
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
          $(this).before('<a class="menu-toggle" title="' + title + '"><span class="lines"><span class="line first-line first"></span><span class="line"></span><span class="line last-line last"></span></span><span class="toggle-help">' + menuToggleHelper + '</span></a>');
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
          $(this).children('.sub-menu').addClass('active');
        },
        function() {
          $(this).children('.sub-menu').removeClass('active');
        }
      );
    }
  }
})(jQuery);
;
