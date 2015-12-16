var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');
var gulpIf = require('gulp-if');

var $ = require('gulp-load-plugins')();

gulp.task('scripts', function () {
    return gulp.src(path.join(conf.paths.src, '/**/*.js'))
        .pipe($.eslint())
        .pipe($.eslint.format())
        .pipe($.ngAnnotate())
        .pipe($.angularFilesort())
        .pipe(gulpIf(!conf.isProduction, $.sourcemaps.init()))
        .pipe(gulpIf(conf.isProduction, $.uglify({ preserveComments: $.uglifySaveLicense })).on('error', conf.errorHandler('Uglify')))
        .pipe($.concat('app.js'))
        .pipe(gulpIf(!conf.isProduction, $.sourcemaps.write('maps')))
        .pipe(gulp.dest(conf.paths.jsOut))
        .pipe($.size());
});
