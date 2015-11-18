var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');

var $ = require('gulp-load-plugins')();

gulp.task('scripts', function () {
    return gulp.src(path.join(conf.paths.src, '/**/*.js'))
        .pipe($.angularFilesort())
        .pipe($.eslint())
        .pipe($.eslint.format())
        .pipe($.ngAnnotate())
        .pipe($.sourcemaps.init())
        .pipe($.uglify({ preserveComments: $.uglifySaveLicense })).on('error', conf.errorHandler('Uglify'))
        .pipe($.sourcemaps.write('maps'))
        .pipe(browserSync.reload({ stream: true }))
        .pipe($.size());
});
