/**
 * @file
 * Task: Bundle and transpile es6 modules for use clientside.
 */

/* global module */

// var webpack = require('webpack');

module.exports = function (gulp, plugins, options) {
  'use strict';

  gulp.task('webpack:js', function () {
    return gulp.src([
      options.webpack.source + '**/*.js'
    ])
        .pipe(plugins.plumber())
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.gulpWebpack(require('./../webpack.config.js'), plugins.webpack))
        .pipe(plugins.sourcemaps.write())
        .pipe(plugins.plumber.stop())
        .pipe(gulp.dest(options.js.destination));
  });
};
