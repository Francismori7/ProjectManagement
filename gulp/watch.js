var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')();

gulp.task('watch', ['build'], function () {

    $.livereload.listen();

    gulp.watch(['bower.json'], ['bower']);

    gulp.watch(path.join(conf.paths.src, '/**/*.scss'), function(event) {
        gulp.start('styles');
    });

    gulp.watch([
        path.join(conf.paths.src, '/**/*.html')
    ], function(event) {
        gulp.start('partials');
    });

    gulp.watch(path.join(conf.paths.src, '/**/*.js'), function(event) {
        gulp.start('scripts');
    });
});
