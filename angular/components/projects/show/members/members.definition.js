(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .directive('projectMembers', projectMembers);

    /* @ngInject */
    function projectMembers() {
        return {
        	scope: {
        		project: '='
        	},
            controller: 'ProjectMembersCtrl',
            controllerAs: 'vm',
        	templateUrl: '/components/projects/show/members/members.html'
        };
    }

})(window.angular);
