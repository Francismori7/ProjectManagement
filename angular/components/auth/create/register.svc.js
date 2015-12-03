(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth.create')
		.factory('RegisterSvc', RegisterSvc);

	/* @ngInject */
	function RegisterSvc($stateParams, AuthSvc) {
		return {
			register: register
		};

		function register(user) {
			return AuthSvc.register($stateParams.token, user);
		}
	}
})(window.angular);