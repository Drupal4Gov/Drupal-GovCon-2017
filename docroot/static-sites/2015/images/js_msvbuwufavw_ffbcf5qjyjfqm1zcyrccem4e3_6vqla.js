(function ($) {

  /**
   * The recommended way for producing HTML markup through JavaScript is to write
   * theming functions. These are similiar to the theming functions that you might
   * know from 'phptemplate' (the default PHP templating engine used by most
   * Drupal themes including Omega). JavaScript theme functions accept arguments
   * and can be overriden by sub-themes.
   *
   * In most cases, there is no good reason to NOT wrap your markup producing
   * JavaScript in a theme function.
   */

  Drupal.theme.prototype.govconBevelBox = function (e) {
    // Create bevel markup
    $(e).prepend('<div class="bg-overlay"></div>')
      .prepend('<div class="tr"></div>')
      .prepend('<div class="tl"></div>')
      .prepend('<div class="br"></div>')
      .prepend('<div class="bl"></div>')
      .prepend('<div class="bg"></div>');

  };

  /**
   * Behaviors are Drupal's way of applying JavaScript to a page. In short, the
   * advantage of Behaviors over a simple 'document.ready()' lies in how it
   * interacts with content loaded through Ajax. Opposed to the
   * 'document.ready()' event which is only fired once when the page is
   * initially loaded, behaviors get re-executed whenever something is added to
   * the page through Ajax.
   *
   * You can attach as many behaviors as you wish. In fact, instead of overloading
   * a single behavior with multiple, completely unrelated tasks you should create
   * a separate behavior for every separate task.
   *
   * In most cases, there is no good reason to NOT wrap your JavaScript code in a
   * behavior.
   *
   * @param context
   *   The context for which the behavior is being executed. This is either the
   *   full page or a piece of HTML that was just added through Ajax.
   * @param settings
   *   An array of settings (added through drupal_add_js()). Instead of accessing
   *   Drupal.settings directly you should use this because of potential
   *   modifications made by the Ajax callback that also produced 'context'.
   */

  Drupal.behaviors.govconBevelBox = {
    attach: function (context, settings) {
      $('.bevel', context).once('bevel', function () {
        Drupal.theme('govconBevelBox', this);
      });
    }
  };

})(jQuery);
;
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
          $(this).before('<a class="menu-toggle" title="Menu">Menu</a>');
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
