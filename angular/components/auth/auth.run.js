(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.run(RunAuth);

	/* @ngInject */
	function RunAuth($rootScope, $state, $sessionStorage, AuthSvc, AuthState) {
		$rootScope.$on("unauthorized", function() {
			AuthSvc.logout();
			AuthSvc.setIntendedState($state.current);
			$state.go('app.auth.login');
		});

		$rootScope.$on("$stateChangeStart", function(evt, toState) {
			toState.data = toState.data || {};

			var requiredAuthState = toState.data.authState;
			if (requiredAuthState !== undefined) {
				if (requiredAuthState === AuthState.AUTHENTICATED && !AuthSvc.isLoggedIn()) {
					AuthSvc.setIntendedState(toState);
					$state.go('app.auth.login');
				} else if (requiredAuthState === AuthState.GUEST && AuthSvc.isLoggedIn()) {
					evt.preventDefault();
				}
			}
		});
	}

})(window.angular);