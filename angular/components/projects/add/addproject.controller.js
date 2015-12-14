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
        vm.isLoading  = false;

        function addProject(project) {
            vm.isLoading = true;
            vm.errors = [];
            ProjectsSvc.create(project)
                .then(function() {
                    $mdDialog.hide();
                })
                .catch(function(errors) {
                    vm.errors = errors;
                })
                .finally(function() {
                    vm.isLoading = false;
                });
        }

        function cancel() {
            $mdDialog.cancel();
        }
    }

})();
