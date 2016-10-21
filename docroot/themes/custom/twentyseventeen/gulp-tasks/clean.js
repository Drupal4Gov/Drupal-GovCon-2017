/**
 * @file
 * Task: Clean.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  gulp.task('clean', ['clean:css', 'clean:styleguide']);
};
