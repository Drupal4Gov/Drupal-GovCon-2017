/**
 * @file
 * Task: Compile: Styleguide.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('compile:styleguide', function (cb) {
    return plugins.kss(options.styleGuide, cb);
  });
};
