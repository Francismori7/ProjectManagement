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
        vm.getAssigneeFromId = getAssigneeFromId;

        (function() {
            var i, state;
            for (i = 0; i < vm.tabs.length; i++) {
                state = 'app.projects.show.' + vm.tabs[i].state;
                vm.tabs[i].isActive = $state.current.name == state;
            }

            vm.project = ProjectsSvc.get($stateParams.projectId);
        })();

        function switchTab(childState) {
            $state.go('app.projects.show.' + childState);
        }

        function getAssigneeFromId(id) {
            var i, assignees = vm.project.assignees;

            for (i = 0; i < assignees.length; i++) {
                if (assignees[i].id === id)
                    return assignees[i];
            }

            return null;
        }
    }

})();
