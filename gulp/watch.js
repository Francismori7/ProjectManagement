var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')();

var browserSync = require('browser-sync');

gulp.task('watch', function () {

    gulp.watch(['bower.json'], ['bower']);

    gulp.watch([
        path.join(conf.paths.src, '/app/**/*.css'),
        path.join(conf.paths.src, '/app/**/*.scss')
    ], function(event) {
        if(isOnlyChange(event)) {
            gulp.start('styles');
        }
    });

    gulp.watch(path.join(conf.paths.src, '/**/*.js'), function(event) {
        if(isOnlyChange(event)) {
            gulp.start('scripts');
        } else {
            gulp.start('inject');
        }
    });
});
