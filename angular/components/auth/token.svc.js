(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.factory('TokenSvc', TokenSvc);

	/* @ngInject */
	function TokenSvc($localStorage) {
		var STORE_KEY = "token";

		return {
			getToken: getToken,
			setToken: setToken,
			hasToken: hasToken,
			deleteToken: deleteToken
		};

		function getToken() {
			return $localStorage[STORE_KEY];
		}

		function setToken(token) {
			$localStorage[STORE_KEY] = token;
		}

		function hasToken() {
			return getToken() !== undefined;
		}

		function deleteToken() {
			delete $localStorage[STORE_KEY];
		}
	}

})(window.angular);