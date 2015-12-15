(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.run(RunAuth);

	/* @ngInject */
	function RunAuth($rootScope, $state, $timeout, $mdDialog, TokenSvc, AuthSvc, AuthState) {
		$rootScope.$on("unauthorized", function() {
			AuthSvc.logout();
			AuthSvc.setIntendedState($state.current);
			$mdDialog.hide();
			$state.go('app.auth.login');
		});

		$rootScope.$on("newToken", function(evt, newToken) {
			TokenSvc.setToken(newToken.split(' ')[1]);
		});

		$rootScope.$on("$stateChangeStart", function(evt, toState) {
			$timeout(function() {
				toState.data = toState.data || {};

				var requiredAuthState = toState.data.authState;
				if (requiredAuthState !== undefined) {
					if (requiredAuthState === AuthState.AUTHENTICATED && !AuthSvc.isLoggedIn()) {
						AuthSvc.setIntendedState(toState);
						$state.go('app.auth.login');
					} else if (requiredAuthState === AuthState.GUEST && AuthSvc.isLoggedIn()) {
						$state.go('app.dashboard');
					}
				}
			});
		});
	}

})(window.angular);