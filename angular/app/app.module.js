(function(angular) {
    'use strict';

    angular.module('creaperio', [
        'app.login',
		'app.common',
		/* @registerNgModule */
    ]);

    angular.module('app.login', []);
	angular.module('app.common', []);
	/* @defineNgModule */

})(window.angular);
