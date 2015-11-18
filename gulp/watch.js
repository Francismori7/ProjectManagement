var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')();

var browserSync = require('browser-sync');

gulp.task('watch', function () {

    gulp.watch(['bower.json'], ['bower']);

    gulp.watch(path.join(conf.paths.src, '/app/**/*.scss'), function(event) {
        gulp.start('styles');
    });

    gulp.watch(path.join(conf.paths.src, '/**/*.js'), function(event) {
        gulp.start('scripts');
    });
});
