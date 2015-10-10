(function(angular) {
    'use strict';

    angular.module('creaperio', [
        'ui.router',

        'app.login',
		'app.common',
				'app.navigation',
/* @registerNgModule */
    ]);

    angular.module('app.login', []);
	angular.module('app.common', []);
		angular.module('app.navigation', []);
/* @defineNgModule */

})(window.angular);
