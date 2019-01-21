/**
 * @file
 * Task: Clean:Styleguide.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  // Clean style guide files.
  gulp.task('clean:styleguide', function () {
    // You can use multiple globbing patterns as you would with `gulp.src`.
    plugins.del.sync([
      options.styleGuide.destination + '*.html',
      options.styleGuide.destination + 'public',
      options.css.destination + '**/*.twig'
    ]);
  });
};
