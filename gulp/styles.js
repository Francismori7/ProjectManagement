var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');
var gulpIf = require('gulp-if');

var $ = require('gulp-load-plugins')();

gulp.task('styles', function () {
    var sassOptions = {
        outputStyle: conf.isProduction ? 'compressed' : 'expanded'
    };

    var injectFiles = gulp.src([
        path.join(conf.paths.src, '/**/*.scss'),
        path.join('!' + conf.paths.src, '/index.scss')
    ], { read: false });

    var injectOptions = {
        transform: function(filePath) {
            filePath = filePath.replace(conf.paths.src + '/', '');

            return '@import "' + filePath + '";';
        },
        starttag: '// injector',
        endtag: '// endinjector',
        addRootSlash: false
    };

    return gulp.src([
        path.join(conf.paths.src, '/index.scss')
    ]).pipe($.inject(injectFiles, injectOptions))
        .pipe(gulpIf(!conf.isProduction, $.sourcemaps.init()))
        .pipe($.sass(sassOptions)).on('error', conf.errorHandler('Sass'))
        .pipe($.autoprefixer()).on('error', conf.errorHandler('Autoprefixer'))
        .pipe(gulpIf(!conf.isProduction, $.sourcemaps.write()))
        .pipe(gulp.dest(conf.paths.cssOut))
        .pipe($.livereload());
});
