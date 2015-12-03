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
	}

})(window.angular);