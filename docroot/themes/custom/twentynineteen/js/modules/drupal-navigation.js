/**
 * Drupal Behavior.
 *
 * The original module export has been replaced with the following Drupal
 * behavior, which takes advantage of the context object when initializing the
 * carousel.
 */

((Drupal, drupalSettings) => {
  'use strict';

  Drupal.behaviors.navgiation = {
    attach: (context, settings) => {
      const topMenuLinks = context.querySelectorAll('.menu-main__item > a');
      const subMenu = context.querySelectorAll('.menu-submenu');
    }
  }


})(Drupal, drupalSettings);
