(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.service('AuthInterceptor', AuthInterceptor);

	/* @ngInject */
	function AuthInterceptor($q, $rootScope, TokenSvc) {
		this.request = function(config) {
			config.headers = config.headers || {};

			if (TokenSvc.hasToken())
				config.headers['Authorization'] = 'Bearer ' + TokenSvc.getToken();

			return config;
		};

		this.response = function(response) {
			var headers = response.headers();
			
			if (headers.authorization) {
				$rootScope.$broadcast("newToken", headers.authorization);
			}

			return response;
		};

		this.responseError = function(response) {
			if (response.status === 401)
				$rootScope.$broadcast("unauthorized");
			
			return $q.reject(response);
		};
	}

})(window.angular);