/**
 * @file
 * Task: Compile: SVG.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('compile:svg', function () {
    return gulp.src(options.svg.files)
    .pipe(plugins.svgstore())
    .pipe(gulp.dest(options.svg.destination));
  });
};
