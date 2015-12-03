(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.service('AuthInterceptor', AuthInterceptor);

	/* @ngInject */
	function AuthInterceptor($q, $rootScope) {
		this.responseError = function(response) {
			if (response.status === 401)
				$rootScope.$broadcast("unauthorized");
			
			return $q.reject(response);
		};
	}

})(window.angular);