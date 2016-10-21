/**
 * @file
 * Task: Test: CSS.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('test:css', function () {
    return gulp.src(options.css.file)
      .pipe(plugins.plumber())
      .pipe(plugins.parker());
  });
};
