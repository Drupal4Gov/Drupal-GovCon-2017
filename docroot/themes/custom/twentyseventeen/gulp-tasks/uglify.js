/**
 * @file
 * Task: Uglify.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('uglify:js', function () {
    return gulp.src(options.js.files)
      .pipe(gulp.dest(options.js.destination));
  });
};
