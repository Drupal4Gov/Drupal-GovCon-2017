/**
 * @file
 * Example javascript file.
 */

(function ($, Drupal, window, document) {
  'use strict';

  // Example of Drupal behavior loaded.
  Drupal.behaviors.exampleJS = {
    attach: function (context, settings) {
      if (typeof context['location'] !== 'undefined') { // Only fire on document load.

        /* console.log('theme.js loaded'); */

      }
    }
  };

})(jQuery, Drupal, this);
