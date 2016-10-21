/**
 * @file
 * Task: Compile: Styleguide.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('compile:styleguide', function (cb) {
    plugins.kss(options.styleGuide, cb);
  });
};
