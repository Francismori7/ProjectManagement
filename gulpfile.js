var elixir = require('laravel-elixir');
require('./tasks/bower.task');
require('./tasks/angular.task');
require('laravel-elixir-livereload');

elixir(function (mix) {
    mix.bowerCss()
        .bowerJs()
        .angular('./angular/', 'app.js', 'public/js')
        .sass('./angular/main.scss', 'public/css', {
            includePaths: [
                './bower_components'
            ]
        })
        .copy('./bower_components/font-awesome/fonts', 'public/fonts')
        .copy('./angular/app/**/*.html', 'public/views/app/')
        .copy('./angular/directives/**/*.html', 'public/views/directives/')
        .copy('./angular/dialogs/**/*.html', 'public/views/dialogs/')
        .livereload([
            'public/js/vendor.js',
            'public/js/app.js',
            'public/css/vendor.css',
            'public/css/main.css',
            'public/views/**/*.html'
        ], {liveCSS: true});
});
