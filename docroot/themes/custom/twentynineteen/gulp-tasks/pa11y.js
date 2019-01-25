/**
 * @file
 * Task: pa11y.
 * Pa11y tests websites for accessibility issues. http://pa11y.org/.
 */

module.exports = function (gulp, plugins, options) {
  'use strict';

  var pa11y = plugins.pa11y;
  var gutil = plugins.gutil;

  gulp.task('pa11y-test', function (cb) {

    plugins.gutil.log('Accessibility Audit starts');
    var pa11yTest = pa11y(options.pa11y);
    var errors = 0;
    var warnings = 0;
    var notices = 0;
    options.pa11y.urls.forEach(function (url) {
      pa11yTest.run(url, function (error, results) {
        if (error) {
          cb(new gutil.PluginError('pa11y', error));
          return;
        }
        else if (results) {
          for (var key in results) {
            if (Object.prototype.hasOwnProperty.call(results, key)) {
              var result = results[key];
              var message = '\n================================================================================\n' +
              url + '\n' +
              result.type + '\n' +
              result.code + '\n'
              + result.context
              + '\n' + result.message
              + '\n' + result.selector +
              '\n================================================================================\n';

              if (result.type === 'error') {
                errors++;
                gutil.log(gutil.colors.red(message));
              }
              else if (result.type === 'warning') {
                warnings++;
                gutil.log(gutil.colors.magenta(message));
              }
              else if (result.type === 'notice') {
                notices++;
                gutil.log(gutil.colors.cyan(message));
              }
            }
          }

          if (options.pa11y.threshold.errors > -1 && errors > options.pa11y.threshold.errors) {
            cb(new gutil.PluginError('pa11y',
              gutil.colors.red(
                '\n================================================================================\n' +
                '  Build failed due to accessibility errors exceeding threshold (' + errors + ' errors) with a threshold of ' + options.pa11y.threshold.errors +
                '\n================================================================================\n' +
                errors + ' errors\n' +
                warnings + ' warnings\n' +
                notices + ' notices\n'
              )
            ));
          }
          else if (options.pa11y.threshold.warnings > -1 && warnings > options.pa11y.threshold.warnings) {
            cb(new gutil.PluginError('pa11y',
              gutil.colors.magenta(
                '\n================================================================================\n' +
                '  Build failed due to accessibility warnings exceeding threshold (' + warnings + ' warnings) with a threshold of ' + options.pa11y.threshold.warnings +
                '\n================================================================================\n' +
                errors + ' errors\n' +
                warnings + ' warnings\n' +
                notices + ' notices\n'
              )
            ));
          }
          else if (options.pa11y.threshold.notices > -1 && notices > options.pa11y.threshold.notices) {
            cb(new gutil.PluginError('pa11y',
              gutil.colors.cyan(
                '\n================================================================================\n' +
                '  Build failed due to accessibility notices exceeding threshold (' + notices + ' notices) with a threshold of ' + options.pa11y.threshold.notices +
                '\n================================================================================\n' +
                errors + ' errors\n' +
                warnings + ' warnings\n' +
                notices + ' notices\n'
              )
            ));
          }
          else {
            gutil.log('pa11y',
              gutil.colors.cyan(
                '\n================================================================================\n' +
                '  Build succeeded.' +
                '\n================================================================================\n' +
                errors + ' errors\n' +
                warnings + ' warnings\n' +
                notices + ' notices\n'
              )
            );
          }
        }
      });
    });
  });
};
