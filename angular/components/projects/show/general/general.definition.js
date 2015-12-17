(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .directive('projectGeneral', projectGeneral);

    /* @ngInject */
    function projectGeneral() {
        return {
        	controller: 'GeneralProjectDetailCtrl',
        	scope: {
        		project: '='
        	},
        	templateUrl: '/components/projects/show/general/general.html'
        };
    }

})(window.angular);
