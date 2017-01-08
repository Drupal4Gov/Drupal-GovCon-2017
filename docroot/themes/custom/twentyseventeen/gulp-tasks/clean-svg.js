/**
 * @file
 * Task: Clean:SVG.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  // Clean SVG sprite.
  gulp.task('clean:svg', function () {
    plugins.del.sync([
      options.svg.destination + '/*.svg'
    ]);
  });
};