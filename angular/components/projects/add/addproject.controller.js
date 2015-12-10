(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('AddProjectCtrl', AddProjectsCtrl);

    /* @ngInject */
    function AddProjectsCtrl($mdDialog, ProjectsSvc) {
        var vm = this;

        vm.cancel     = cancel;
        vm.addProject = addProject;

        function addProject(project) {
            vm.errors = [];
            ProjectsSvc.create(project)
                .then(function() {
                    $mdDialog.hide();
                })
                .catch(function(errors) {
                    vm.errors = errors;
                });
        }

        function cancel() {
            $mdDialog.cancel();
        }
    }

})();
