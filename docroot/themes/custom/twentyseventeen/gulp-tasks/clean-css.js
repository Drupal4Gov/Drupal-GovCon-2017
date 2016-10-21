/**
 * @file
 * Task: Clean:CSS.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  // Clean CSS files.
  gulp.task('clean:css', function () {
    plugins.del.sync([
      options.css.files
    ]);
  });
};
