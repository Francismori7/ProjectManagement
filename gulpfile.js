var elixir = require('laravel-elixir');
require('./tasks/bower.task');

elixir(function(mix) {
    mix.bowerCss()
        .bowerJs();
});
