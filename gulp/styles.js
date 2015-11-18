var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');
var gutil = require('gulp-util');

var $ = require('gulp-load-plugins')();

gulp.task('styles', function () {
    var sassOptions = {
        style: 'expanded'
    };

    var injectFiles = gulp.src([
        path.join(conf.paths.src, '/**/*.scss'),
        path.join('!' + conf.paths.src, '/index.scss')
    ], { read: false });

    var injectOptions = {
        transform: function(filePath) {
            filePath = filePath.replace(conf.paths.src + '/', '');
            gutil.log("Filepath: " + filePath);

            return '@import "' + filePath + '";';
        },
        starttag: '// injector',
        endtag: '// endinjector',
        addRootSlash: false
    };

    return gulp.src([
        path.join(conf.paths.src, '/index.scss')
    ]).pipe($.inject(injectFiles, injectOptions))
        .pipe($.sourcemaps.init())
        .pipe($.sass(sassOptions)).on('error', conf.errorHandler('Sass'))
        .pipe($.autoprefixer()).on('error', conf.errorHandler('Autoprefixer'))
        .pipe($.sourcemaps.write())
        .pipe(gulp.dest(conf.paths.cssOut))
        .pipe(browserSync.reload({ stream: true }));
});
