/**
 * @file
 * Task: Clean:Styleguide.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  // Clean style guide files.
  gulp.task('clean:styleguide', function () {
    // You can use multiple globbing patterns as you would with `gulp.src`.
    plugins.del.sync([
      options.styleGuide.destination + '*.html',
      options.styleGuide.destination + 'public',
      options.css.destination + '**/*.hbs'
    ]);
  });
};
