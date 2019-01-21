/**
 * @file
 * Task: Serve.
 */

/* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('serve', ['build:dev', 'browser-sync', 'watch']);
};
