(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ShowProjectCtrl', ShowProjectCtrl);

    /* @ngInject */
    function ShowProjectCtrl($stateParams, $state, ProjectsSvc) {
        var vm = this;

        // vm.tabs = [
        //     {label: "General", state: "general"},
        //     {label: "Tasks", state: "tasks"},
        //     {label: "Project Members", state: "members"},
        //     {label: "Settings", state: "settings"}
        // ];

        // vm.switchTab = switchTab;
        
        (function() {
            // var i, state;
            // for (i = 0; i < vm.tabs.length; i++) {
            //     state = 'app.projects.show.' + vm.tabs[i].state;
            //     vm.tabs[i].isActive = $state.current.name == state;
            // }

            ProjectsSvc.get($stateParams.projectId)
                .then(function(project) {
                    vm.project = project;
                });
        })();

        // function switchTab(childState) {
        //     $state.go('app.projects.show.' + childState, $stateParams, {notify: false});
        // }

        
    }

})(window.angular);
