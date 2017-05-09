/**
 * @file
 * Example javascript file.
 */

(function ($, Drupal, window, document) {
  'use strict';

  // Example of Drupal behavior loaded.
  Drupal.behaviors.menuTabbing = {
    attach: function (context, settings) {
      if (typeof context['location'] !== 'undefined') { // Only fire on document load.
        var secondLevelNav = $('.nav__items--second-level').children();
        var secondLevelNavLinks = secondLevelNav.children();
        secondLevelNavLinks.focus(function () {
          // Changes the CSS of the ul to appear on focus.
          $(this).parent().parent().addClass('focus');
        });
        secondLevelNavLinks.blur(function () {
          // Controls the CSS of the ul when you exit out of that particular submenu.
          $(this).parent().parent().removeClass('focus');
        });
      }
    }
  };

})(jQuery, Drupal, this);
