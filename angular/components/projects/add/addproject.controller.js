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
            vm.alertErrors = [];
            ProjectsSvc.create(project)
                .then(function() {
                    $mdDialog.hide();
                })
                .catch(function(response) {
                    if (response.status === 422)
                        vm.errors = response.errors;
                    else
                        vm.alertErrors = response.errors;
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
