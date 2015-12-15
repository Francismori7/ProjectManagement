(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ShowProjectCtrl', ShowProjectCtrl);

    /* @ngInject */
    function ShowProjectCtrl($stateParams, $state, ProjectsSvc) {
        var vm = this;

        vm.tabs = [
            {label: "General", state: "general"},
            {label: "Tasks", state: "tasks"},
            {label: "Project Members", state: "members"},
            {label: "Settings", state: "settings"}
        ];

        vm.switchTab = switchTab;
        vm.getUserFromId = getUserFromId;
        vm.getNameFromUser = getNameFromUser;

        (function() {
            var i, state;
            for (i = 0; i < vm.tabs.length; i++) {
                state = 'app.projects.show.' + vm.tabs[i].state;
                vm.tabs[i].isActive = $state.current.name == state;
            }

            ProjectsSvc.get($stateParams.projectId)
                .then(function(project) {
                    vm.project = project;
                });
        })();

        function switchTab(childState) {
            $state.go('app.projects.show.' + childState);
        }

        function getUserFromId(id) {
            if (id === undefined)
                return {};

            var i, assignees = vm.project.users;

            for (i = 0; i < assignees.length; i++) {
                if (assignees[i].id === id)
                    return assignees[i];
            }

            return null;
        }

        function getNameFromUser(user) {
            return user.first_name + " " + user.last_name;
        }
    }

})(window.angular);
