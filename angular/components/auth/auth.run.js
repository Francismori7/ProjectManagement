(function(angular) {
	'use strict';

	angular
		.module('creaperio.auth')
		.run(RunAuth);

	/* @ngInject */
	function RunAuth($rootScope, $state, $sessionStorage, AuthSvc) {
		$rootScope.$on("unauthorized", function() {
			AuthSvc.logout();
			$sessionStorage.intended_state = $state.current;
			$state.go('app.auth.login');
		});

		$rootScope.$on("$stateChangeStart", function(evt, toState) {
			if (toState.data.authState !== undefined && toState.data.authState === 'auth' && !AuthSvc.isLoggedIn()) {
				$sessionStorage.intended_state = toState;
				$state.go('app.auth.login');
			}
		});
	}

})(window.angular);