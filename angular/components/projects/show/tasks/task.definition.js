(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .directive('projectTasks', projectTasks);

    /* @ngInject */
    function projectTasks() {
        return {
        	scope: {
        		project: '='
        	},
            controller: 'ProjectTaskCtrl',
            controllerAs: 'vm',
        	templateUrl: '/components/projects/show/tasks/tasks.html'
        };
    }

})(window.angular);
