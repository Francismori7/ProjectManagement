var Elixir = require('laravel-elixir');
var gulp = require('gulp');
var mainBowerFiles = require('main-bower-files');
var concat = require('gulp-concat');
var concatsm = require('gulp-concat-sourcemap');
var gulpIf = require('gulp-if');
var minify = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');

var Task = Elixir.Task;

var notifySuccess = function(type) {
    return notify({
        title: "Laravel Elixir",
        subtitle: "Bower " + type + " Files Compiled!",
        icon: __dirname + "/../node_modules/laravel-elixir/icons/laravel.png"
    });
};

var onError = function(type) {
    return function(err) {
        notify.onError({
            title: "Laravel Elixir",
            subtitle: "Bower " + type + " Files Compilation Failed!",
            message: "Error: <%= error.message %>",
            icon: __dirname + "/../node_modules/laravel-elixir/icons/fail.png"
        })(err);
    };
};

if (!Elixir.config.production)
    concat = concatsm;

Elixir.extend('bowerCss', function(outputDirectory, outputFile) {

    var dir = outputDirectory || 'public/css';
    var file = outputFile || 'vendor.css';

    new Task('bower-css', function() {
        var files = mainBowerFiles('**/*.css');

        gulp.src(files)
            .on('error', onError)
            .pipe(concat(file))
            .pipe(gulpIf(Elixir.config.production, minify()))
            .pipe(gulp.dest(dir))
            .pipe(notifySuccess("CSS"));
    }).watch('bower.json');
});

Elixir.extend('bowerJs', function(outputDirectory, outputFile) {

    var dir = outputDirectory || 'public/js';
    var file = outputFile || 'vendor.js';

    new Task('bower-js', function() {
        var files = mainBowerFiles('**/*.js');

        gulp.src(files)
            .on('error', onError)
            .pipe(concat(file))
            .pipe(gulpIf(Elixir.config.production, uglify()))
            .pipe(gulp.dest(dir))
            .pipe(notifySuccess("JS"));
    }).watch('bower.json');
});
