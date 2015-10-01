var elixir = require('laravel-elixir');
require('./tasks/bower.task');
require('./tasks/angular.task');
require('laravel-elixir-livereload');

elixir(function (mix) {
    mix.bowerCss()
        .bowerJs()
        .angular('./angular/', 'angular.js', 'public/js')
        .scripts('**/*.js', 'public/js/app.js')
        .sass('**/*.scss', 'public/css')
        .sass('./angular/**/*.scss', 'public/css/angular.css')
        .copy('./angular/app/**/*.html', 'public/views/app/')
        .copy('./angular/directives/**/*.html', 'public/views/directives/')
        .copy('./angular/dialogs/**/*.html', 'public/views/dialogs/')
        .livereload([
            'public/js/vendor.js',
            'public/js/app.js',
            'public/css/vendor.css',
            'public/css/app.css',
            'public/css/angular.css',
            'public/views/**/*.html'
        ], {liveCSS: true});
});
