(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ProjectMembersCtrl', ProjectMembersCtrl);

    /* @ngInject */
    function ProjectMembersCtrl($scope, $timeout, UserSvc) {
        var vm = this;

        vm.getUserFromId = UserSvc.getUserFromId($scope.project);
        vm.getNameFromUser = UserSvc.getNameFromUser;
    }

})(window.angular);
