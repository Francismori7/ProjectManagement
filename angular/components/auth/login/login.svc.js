(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth.login')
		.factory('LoginSvc', LoginSvc);

	/* @ngInject */
	function LoginSvc($state, AuthSvc) {
		return {
			login: login
		};

		function login(user) {
			return AuthSvc.login(user)
				.then(function() {
					$state.go(AuthSvc.getIntendedState());
				});
		}
	}
})(window.angular);