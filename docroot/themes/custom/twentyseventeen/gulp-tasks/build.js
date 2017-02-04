/**
 * @file
 * Task: Build.
 */

'use strict';
module.exports = function (gulp, plugins, options) {

  gulp.task('build', function (cb) {
    plugins.runSequence(
        ['compile:sass'],
        ['clean:svg'],
        ['compile:styleguide', 'compile:svg', 'minify:css'],
        ['lint:js-gulp', 'lint:js-with-fail'], cb
    );
  });

  gulp.task('build:dev', function (cb) {
    plugins.runSequence(
        ['compile:sass'],
        ['clean:svg'],
        ['compile:styleguide', 'compile:svg', 'minify:css'],
        ['lint:js-gulp', 'lint:js'], cb
    );
  });
};
