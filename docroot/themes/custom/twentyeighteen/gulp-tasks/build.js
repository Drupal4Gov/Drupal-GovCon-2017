/**
 * @file
 * Task: Build.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('build', [
    'compile:sass',
    'minify:css',
    'compile:styleguide',
    'lint:js-gulp',
    'lint:js-with-fail',
    'lint:css-with-fail'
  ]);

  gulp.task('build:dev', [
    'compile:sass',
    'minify:css',
    'compile:styleguide',
    'lint:js-gulp',
    'lint:js',
    'lint:css'
  ]);
};
