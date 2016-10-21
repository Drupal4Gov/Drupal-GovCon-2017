/**
 * @file
 * Task: Compile: Sass.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('compile:sass', function () {
    return gulp.src([
      options.sass.files
    ])
      .pipe(plugins.sourcemaps.init())
      .pipe(plugins.sassGlob())
      .pipe(plugins.sass({
        errLogToConsole: true,
        outputStyle: 'expanded'
      }))
      .pipe(plugins.autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
      }))
      .pipe(plugins.sourcemaps.write())
      .pipe(gulp.dest(options.sass.destination));
  });
};
