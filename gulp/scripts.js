var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');

var $ = require('gulp-load-plugins')();

gulp.task('scripts', function () {
    return gulp.src(path.join(conf.paths.src, '/**/*.js'))
        .pipe($.eslint())
        .pipe($.eslint.format())
        .pipe($.ngAnnotate())
        .pipe($.angularFilesort())
        .pipe($.sourcemaps.init())
        .pipe($.uglify({ preserveComments: $.uglifySaveLicense })).on('error', conf.errorHandler('Uglify'))
        .pipe($.concat('app.js'))
        .pipe($.sourcemaps.write('maps'))
        .pipe(gulp.dest(conf.paths.jsOut))
        .pipe(browserSync.reload({ stream: true }))
        .pipe($.size());
});
