(function(angular) {
	'use strict';

	angular
		.module('creaperio.common')
		.directive('errorBag', ErrorBag);

	/* @ngInject */
	function ErrorBag() {
		return {
			templateUrl: '/common/directives/error-bag/error-bag.html',
			scope: {
				errors: '=',
				type: '&'
			}
		}
	}

})(window.angular);