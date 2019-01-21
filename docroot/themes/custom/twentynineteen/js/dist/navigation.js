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


var topMenuLinks = document.querySelectorAll('.menu-main__item > a');

/**
 * Adds a focus class to top level list items
 * @return {void}
 */

var _loop = function _loop(i) {
  topMenuLinks[i].onfocus = function () {
    topMenuLinks[i].parentElement.classList.add('focus');
  };
};

for (var i = 0; i < topMenuLinks.length; i++) {
  _loop(i);
}

var subMenu = document.querySelectorAll('.menu-submenu');

/**
 * Removes focus class to top level list item when blur off last submenu item
 * @return {void}
 */

var _loop2 = function _loop2(i) {
  var subMenuLinks = subMenu[i].querySelectorAll('a');

  subMenuLinks[subMenuLinks.length - 1].onblur = function () {
    subMenuLinks[subMenuLinks.length - 1].parentElement.parentElement.parentElement.classList.remove('focus');
  };
};

for (var i = 0; i < subMenu.length; i++) {
  _loop2(i);
}

// const mainMenu = document.querySelector('.menu-main');
//
// const lastTopMenuLink = topMenuLinks[topMenuLinks.length - 1];
//
/**
 * Closes the mobile menu when you exit the last link
 * @return {void}
 */
// if (mainMenu.lastElementChild.querySelector('.menu-submenu') === null ) {
//   // If the last menu item does not have a submenu
//   lastTopMenuLink.onblur = () => {
//     document.getElementById('show-menu').checked = false;
//   }
// } else {
//   // If the last menu item does have a submenu
//   const lastSubMenuLink = mainMenu.lastElementChild.querySelector('.menu-submenu');
//
//   lastSubMenuLink.lastElementChild.lastElementChild.onblur = () => {
//     document.getElementById('show-menu').checked = false;
//   }
// }

var toggleButton = document.getElementById('show-menu');
var userMenu = document.querySelector('.menu--account');
var userMenuLinks = userMenu.getElementsByTagName('a');

/**
 * Closes the mobile menu when you exit the user menu
 * @return {void}
 */
userMenuLinks[userMenuLinks.length - 1].onblur = function () {
  toggleButton.checked = false;
  userMenu.classList.remove('menu--account--show');g;
};

console.log(userMenu.getElementsByTagName('a')[userMenu.getElementsByTagName('a').length - 1]);

/**
 * Overrides "checkmark" behavior so that you can use the enter key to toggle the mobile menu.
 * @return {void}
 */
toggleButton.addEventListener("keyup", function (event) {
  event.preventDefault();
  if (event.keyCode === 13 || event.keyCode === 32) {
    if (toggleButton.checked === false) {
      toggleButton.checked = true;
      userMenu.classList.add('menu--account--show');
    } else {
      toggleButton.checked = false;
      userMenu.classList.remove('menu--account--show');
    }
  }
});

toggleButton.addEventListener("click", function () {
  if (toggleButton.checked === true) {
    userMenu.classList.add('menu--account--show');
  } else {
    userMenu.classList.remove('menu--account--show');
  }
});

/***/ })
/******/ ]);