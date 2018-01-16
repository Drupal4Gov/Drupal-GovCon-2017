/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Drupal Behavior.
 *
 * The original module export has been replaced with the following Drupal
 * behavior, which takes advantage of the context object when initializing the
 * carousel.
 */

(function (Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.navgiation = {
    attach: function attach(context, settings) {

      var topMenuLinks = context.querySelectorAll('.menu-main__item > a');

      // console.log(topMenuLinks);

      var _loop = function _loop(i) {
        topMenuLinks[i].onfocus = function () {
          topMenuLinks[i].parentElement.classList.add('focus');
        };
      };

      for (var i = 0; i < topMenuLinks.length; i++) {
        _loop(i);
      }

      var subMenu = context.querySelectorAll('.menu-submenu');

      var _loop2 = function _loop2(i) {
        var subMenuLinks = subMenu[i].querySelectorAll('a');

        // console.log(subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement);
        subMenuLinks[subMenuLinks.length - 1].onblur = function () {
          subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement.classList.remove('focus');
        };
      };

      for (var i = 0; i < subMenu.length; i++) {
        _loop2(i);
      }
    }
  };
})(Drupal, drupalSettings);

/***/ })
/******/ ]);