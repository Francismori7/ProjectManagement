(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.config(ConfigAuth);

	/* @ngInject */
	function ConfigAuth($httpProvider) {
		$httpProvider.interceptors.push('AuthInterceptor');
	}

})(window.angular);