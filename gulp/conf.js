/**
 *  This file contains the variables used in other gulp files
 *  which defines tasks
 *  By design, we only put there very generic config values
 *  which are used in several places to keep good readability
 *  of the tasks
 */

var gutil = require('gulp-util');
var argv = require('yargs').argv;

/**
 *  The main paths of your project handle these with care
 */
exports.paths = {
  src: 'angular',
  dist: 'dist',
  tmp: '.tmp',

  cssOut: 'public/css',
  jsOut: 'public/js',
  viewsOut: 'public/views',
  fontsOut: 'public/fonts'
};

/**
 * The environment
 */
exports.isProduction = argv.production;

/**
 *  Common implementation for an error handler of a Gulp plugin
 */
exports.errorHandler = function(title) {
    'use strict';

    return function(err) {
        gutil.log(gutil.colors.red('[' + title + ']'), err.toString());
        this.emit('end');
    };
};
