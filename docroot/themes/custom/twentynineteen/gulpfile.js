let gulp = require('gulp'),
  sass = require('gulp-sass')(require('node-sass'));
  sourcemaps = require('gulp-sourcemaps'),
  cleanCss = require('gulp-clean-css'),
  rename = require('gulp-rename'),
  postcss = require('gulp-postcss'),
  gulpStylelint = require('gulp-stylelint'),
  autoprefixer = require('autoprefixer'),
  babel = require('gulp-babel'),
  styleguide = require('kss'),
  minify = require('gulp-minify');

const paths = {
  scss: {
    src: './scss/*',
    dest: './css',
  },
  js: {
    src: './js/modules/*',
    dest: './js/dist'
  },
  images: 'img/',
  styleGuide: 'styleguide'
}

// Compile sass into CSS & auto-inject into browsers
function styles () {
  return gulp.src([paths.scss.src])
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer({})]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(cleanCss())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.scss.dest));
   // .pipe(gulpStylelint({
   //   reporters: [
   //     {formatter: 'string', console: true}
   // ]
   //}));
}

// Move the javascript files into our js folder
function js () {
  return gulp.src([paths.js.src])
    .pipe(babel({
      presets: ['@babel/env']
    }))
    .pipe(minify({noSource: true}))
    .pipe(gulp.dest(paths.js.dest))
}

const build = gulp.series(styles, js)

exports.styles = styles
exports.js = js

exports.default = build
