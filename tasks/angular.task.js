var Elixir = require('laravel-elixir');
var gulp = require('gulp');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var ngAnnotate = require('gulp-ng-annotate');
var concat = require('gulp-concat');
var concatsm = require('gulp-concat-sourcemap');
var notify = require('gulp-notify');
var stylish = require('jshint-stylish');
var gulpIf = require('gulp-if');
var file = require('file');
var path = require('path');

var Task = Elixir.Task;

var notifySuccess = notify({
    title: "Laravel Elixir",
    subtitle: "Angular Files Compiled!",
    message: ' ',
    icon: __dirname + "/../node_modules/laravel-elixir/icons/laravel.png"
});

var onError = function(err) {
    notify.onError({
        title: "Laravel Elixir",
        subtitle: "Angular Compilation Failed!",
        message: "Error: <%= error.message %>",
        icon: __dirname + "/../node_modules/laravel-elixir/icons/fail.png"
    })(err);

    this.emit('end');
};

Elixir.extend('angular', function(angularDir, jsFile, outputDirectory) {

    var src = angularDir || Elixir.config.assetsPath + '/angular/';
    var output = jsFile || 'app.js';
    var dir = outputDirectory || 'public/js';

    if (!Elixir.config.production)
        concat = concatsm;

    new Task('angular', function() {

        gulp.src(src + '**/*.js')
            .on('error', onError)
            .pipe(jshint())
            .pipe(jshint.reporter(stylish))
            .pipe(ngAnnotate())
            .pipe(concat(output))
            .pipe(gulpIf(Elixir.config.production, uglify()))
            .pipe(gulp.dest(dir))
            .pipe(notifySuccess)
            ;

    }).watch(src + '**/*.js');

});
