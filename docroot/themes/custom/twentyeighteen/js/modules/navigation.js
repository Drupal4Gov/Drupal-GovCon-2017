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

      // console.log(topMenuLinks);

      for (let i = 0; i < topMenuLinks.length; i++) {
        topMenuLinks[i].onfocus = () => {
          topMenuLinks[i].parentElement.classList.add('focus');
        }
      }

      const subMenu = context.querySelectorAll('.menu-submenu');

      for (let i = 0; i < subMenu.length; i++) {
        const subMenuLinks = subMenu[i].querySelectorAll('a');

        // console.log(subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement);
        subMenuLinks[subMenuLinks.length - 1].onblur = () => {
          subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement.classList.remove('focus');
        }
      }
    }
  }


})(Drupal, drupalSettings);