(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ProjectMembersCtrl', ProjectMembersCtrl);

    /* @ngInject */
    function ProjectMembersCtrl(UserSvc) {
        var vm = this;

        vm.getUserFromId = UserSvc.getUserFromId;
        vm.getNameFromUser = UserSvc.getNameFromUser;
    }

})(window.angular);
