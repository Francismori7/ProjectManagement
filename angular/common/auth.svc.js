(function(angular) {
	'use strict';

	angular
		.module('creaperio.common')
		.factory('AuthSvc', AuthSvc);

	/* @ngInject */
	function AuthSvc($q, ApiSvc, $localStorage) {
		var STORE_KEY = "token";
		var intended_state = 'app.dashboard';
		
		return {
			login: login,
			logout: logout,
			register: register,
			isLoggedIn: isLoggedIn,
			getIntendedState: getIntendedState,
			setIntendedState: setIntendedState
		};

		function login(user) {
			var deferred = $q.defer();

			ApiSvc.post('auth/login', user)
				.then(function(response) {
					$localStorage[STORE_KEY] = response.data.token;
					deferred.resolve();
				})
				.catch(function(response) {
					// Return the statuscode as well to allow the consumer
					// to distinguish between validation and server error.
					deferred.reject({
						status: response.status,
						data: response.data
					});
				});

			return deferred.promise;
		}

		function register(token, user) {
			var deferred = $q.defer();

			ApiSvc.post('auth/register/' + token, user)
				.then(function(response) {
					$localStorage[STORE_KEY] = response.data.token;
					return response.data.user;
				})
				.catch(function(response) {
					deferred.reject({
						status: response.status,
						data: response.data
					});
				});

			return deferred.promise;
		}

		function logout() {
			ApiSvc.get('auth/logout');
			delete $localStorage[STORE_KEY];
		}

		function isLoggedIn() {
			return $localStorage[STORE_KEY] !== undefined;
		}

		function getIntendedState() {
			return intended_state;
		}

		function setIntendedState(state) {
			if (typeof state === 'string')
				intended_state = state;
			else if (typeof state === 'object')
				intended_state = state.name;
		}
	}

})(window.angular);