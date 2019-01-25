/**
 * @file
 * Task: Browsersync.
 */

/* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  var browserSync = plugins.browserSync.create();

  gulp.task('browser-sync', function () {
    browserSync.init(options.browserSync);
  });

  gulp.task('browser-sync:reload', function () {
    browserSync.reload();
  });
};
