/**
 * @file
 * Pa11y config.
 */

const isCI = process.env.CI;
const baseURL = isCI ? 'http://127.0.0.1:8888' : 'http://drupalgovcon.lndo.site:8080';

// Add urls for a11y testing here.
const urls = [
    '/',
];

module.exports = {
  defaults: {
    standard: 'WCAG2AA',
    hideElements: ['svg'],
    ignore: ['notice', 'warning'],
    chromeLaunchConfig: {
      args: ['--no-sandbox']
    }
  },
  urls: urls.map(url => `${baseURL}${url}`)
};
