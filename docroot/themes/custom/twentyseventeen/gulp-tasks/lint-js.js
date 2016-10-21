/**
 * @file
 * Task: Lint: Scripts.
 */

'use strict';
module.exports = function (gulp, plugins, options) {
  // Lint JavaScript.
  gulp.task('lint:js', function () {
    return gulp.src(options.jsLinting.files.theme)
      .pipe(plugins.eslint())
      .pipe(plugins.eslint.format());
  });

  gulp.task('lint:js-gulp', function () {
    return gulp.src(options.jsLinting.files.gulp)
      .pipe(plugins.eslint({
        useEslintrc: true,
        ecmaFeatures: {
          modules: true,
          module: true
        },
        env: {
          mocha: true,
          node: true,
          es6: true
        }
      }))
      .pipe(plugins.eslint.format());
  });

  // Lint JavaScript and throw an error for a CI to catch.
  gulp.task('lint:js-with-fail', function () {
    return gulp.src(options.jsLinting.files.theme)
      .pipe(plugins.eslint())
      .pipe(plugins.eslint.format())
      .pipe(plugins.eslint.failOnError());
  });
};
