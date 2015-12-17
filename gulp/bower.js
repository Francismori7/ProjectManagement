var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')({
    pattern: ['gulp-*', 'main-bower-files']
});

gulp.task('bower', function() {
    var jsFilter = $.filter('**/*.js');
    var cssFilter = $.filter('**/*.css');

    gulp.src($.mainBowerFiles())
        .pipe(jsFilter)
        .pipe($.concat('vendor.js'))
        .pipe(gulp.dest(conf.paths.jsOut))
        .pipe($.livereload());

    gulp.src($.mainBowerFiles())
        .pipe(cssFilter)
        .pipe($.concat('vendor.css'))
        .pipe($.minifyCss({compatibility: 'ie8'}))
        .pipe(gulp.dest(conf.paths.cssOut))
        .pipe($.livereload());
});
