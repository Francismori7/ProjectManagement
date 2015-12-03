(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth.create')
		.factory('RegisterSvc', RegisterSvc);

	/* @ngInject */
	function RegisterSvc($state, AuthSvc) {
		return {
			login: login
		};

		function login(user) {
			return AuthSvc.login(user);
		}
	}
})(window.angular);