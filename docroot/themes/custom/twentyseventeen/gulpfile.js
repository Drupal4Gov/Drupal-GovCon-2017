// -------------------------------------
//
//   Gulpfile
//
// -------------------------------------
//
// Available tasks:
//   `gulp`
//   `gulp build`
//   `gulp build:dev`
//   `gulp clean`
//   `gulp clean:css`
//   `gulp clean:styleguide`
//   `gulp compile:sass`
//   `gulp compile:styleguide`
//   `gulp lint:js`
//   `gulp minify:css`
//   `gulp serve`
//   `gulp test:css`
//   `gulp watch`
//   `gulp watch:js`
//   `gulp watch:sass`
//   `gulp watch:styleguide`
//
// -------------------------------------

// -------------------------------------
//   Modules
// -------------------------------------
//
// gulp              : The streaming build system
// gulp-autoprefixer : Prefix CSS
// gulp-concat       : Concatenate files
// gulp-clean-css    : Minify CSS
// gulp-load-plugins : Automatically load Gulp plugins
// gulp-parker       : Stylesheet analysis tool
// gulp-plumber      : Prevent pipe breaking from errors
// gulp-rename       : Rename files
// gulp-sass         : Compile Sass
// gulp-sass-glob    : Provide Sass Globbing
// gulp-sass-lint    : Lint Sass
// gulp-size         : Print file sizes
// gulp-sourcemaps   : Generate sourcemaps
// gulp-uglify       : Minify JavaScript with UglifyJS
// gulp-util         : Utility functions
// gulp-watch        : Watch stream
// browser-sync      : Device and browser testing tool
// del               : delete
// eslint            : JavaScript code quality tool
// kss               : Living Style Guide Generator
// run-sequence      : Run a series of dependent Gulp tasks in order
// -------------------------------------

// -------------------------------------
//   Front End Dependencies
// -------------------------------------
// breakpoint-sass       : Really Simple Media Queries with Sass
// kss                   : A methodology for documenting CSS and building style guides
// node-sass             : Wrapper around libsass
// node-sass-import-once : Custom importer for node-sass that only allows a file to be imported once
// susy                  : Sass power-tools for web layout
// typey                 : A complete framework for working with typography in sass
// -------------------------------------

'use strict';
var gulp = require('gulp');
// Setting pattern this way allows non gulp- plugins to be loaded as well.
var plugins = require('gulp-load-plugins')({
  pattern: '*',
  rename: {
    'node-sass-import-once': 'importOnce',
    'gulp-sass-glob': 'sassGlob',
    'run-sequence': 'runSequence',
    'gulp-clean-css': 'cleanCSS'
  }
});

// Used to generate relative paths for style guide output.
var path = require('path');

// These are used in the options below.
var paths = {
  styles: {
    source: 'sass/',
    destination: 'css/'
  },
  scripts: 'js/',
  images: 'img/',
  styleGuide: 'styleguide'
};

// These are passed to each task.
var options = {

  // ----- CSS ----- //

  css: {
    files: paths.styles.destination + '**/*.css',
    file: paths.styles.destination + '/styles.css',
    destination: paths.styles.destination
  },

  // ----- Sass ----- //

  sass: {
    files: paths.styles.source + '**/*.scss',
    file: paths.styles.source + 'styles.scss',
    destination: paths.styles.destination
  },

  // ----- JS ----- //
  js: {
    files: paths.scripts + '**/*.js',
    destination: paths.scripts

  },

  // ----- Images ----- //
  images: {
    files: paths.images + '**/*.{png,gif,jpg,svg}',
    destination: paths.images
  },

  // ----- eslint ----- //
  jsLinting: {
    files: {
      theme: [
        paths.scripts + '**/*.js',
        '!' + paths.scripts + '**/*.min.js'
      ],
      gulp: [
        'gulpfile.js',
        'gulp-tasks/**/*'
      ]
    }

  },

  // ----- KSS Node ----- //
  styleGuide: {
    source: [
      paths.styles.source
    ],
    destination: 'styleguide/',
    css: [
      path.relative(paths.styleGuide, paths.styles.destination + 'styles.css'),
      path.relative(paths.styleGuide, paths.styles.destination + 'kss-only.css')
    ],
    js: [],
    homepage: 'style-guide-only/homepage.md',
    title: 'Living Style Guide'
  }

};

// Tasks
require('./gulp-tasks/build')(gulp, plugins, options);
require('./gulp-tasks/clean')(gulp, plugins, options);
require('./gulp-tasks/clean-css')(gulp, plugins, options);
require('./gulp-tasks/clean-styleguide')(gulp, plugins, options);
require('./gulp-tasks/compile-sass')(gulp, plugins, options);
require('./gulp-tasks/compile-styleguide')(gulp, plugins, options);
require('./gulp-tasks/default')(gulp, plugins, options);
require('./gulp-tasks/lint-js')(gulp, plugins, options);
require('./gulp-tasks/minify-css')(gulp, plugins, options);
require('./gulp-tasks/test-css')(gulp, plugins, options);
require('./gulp-tasks/watch')(gulp, plugins, options);

// Credits:
//
// - http://drewbarontini.com/articles/building-a-better-gulpfile/
// - https://teamgaslight.com/blog/small-sips-of-gulp-dot-js-4-steps-to-reduce-complexity
// - http://cgit.drupalcode.org/zen/tree/STARTERKIT/gulpfile.js?h=7.x-6.x
// - https://github.com/google/web-starter-kit/blob/master/gulpfile.js
