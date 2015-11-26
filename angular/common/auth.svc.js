(function(angular) {
	'use strict';

	angular
		.module('creaperio.common')
		.factory('AuthSvc', AuthSvc);

	/* @ngInject */
	function AuthSvc(ApiSvc, $localStorage) {
		var STORE_KEY = "token";

		return {
			login: login,
			logout: logout,
			isLoggedIn: isLoggedIn
		};

		function login(user) {
			return ApiSvc.post('auth/login', user)
				.then(function(response) {
					$localStorage[STORE_KEY] = response.data.token;
				});
		}

		function register(user) {
			return ApiSvc.post('auth/register', user)
				.then(function(response) {
					return response.data.user;
				});
		}

		function logout() {
			ApiSvc.get('auth/logout');
			delete $localStorage[STORE_KEY];
		}

		function isLoggedIn() {
			return $localStorage[STORE_KEY] !== undefined;
		}
	}

})(window.angular);