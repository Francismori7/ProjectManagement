var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')({
    pattern: ['gulp-*', 'main-bower-files', 'uglify-save-license']
});

gulp.task('partials', function () {
    return gulp.src([
        path.join(conf.paths.src, '/**/*.html')
    ])
    .pipe($.minifyHtml({
        empty: true,
        spare: true,
        quotes: true
    }))
    .pipe($.angularTemplatecache('templateCacheHtml.js', {
        module: 'creaperio',
        root: '/'
    }))
    .pipe(gulp.dest(conf.paths.viewsOut))
    .pipe($.livereload());
});

gulp.task('fonts', function () {
    return gulp.src('bower_components/material-design-iconfont/iconfont/*')
        .pipe($.filter('**/*.{eot,svg,ttf,woff,woff2}'))
        .pipe($.flatten())
        .pipe(gulp.dest(conf.paths.fontsOut))
        .pipe($.livereload());
});

gulp.task('build', ['bower', 'scripts', 'styles', 'fonts', 'partials']);
