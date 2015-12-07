(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.factory('AuthState', AuthState);

	/* @ngInject */
	function AuthState() {
		return {
			AUTHENTICATED: 'auth',
			GUEST: 'guest'
		};
	}

})(window.angular);