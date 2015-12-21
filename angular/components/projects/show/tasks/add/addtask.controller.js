(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('AddTaskCtrl', AddTaskCtrl);

    /* @ngInject */
    function AddTaskCtrl($mdDialog, TaskSvc, project) {
        var vm = this;

        vm.addTask = addTask;
        vm.cancel = cancel;
        vm.isLoading = false;

        function addTask(task) {
            vm.errors = [];
            vm.isLoading = true;
            TaskSvc.addTask(project, task)
                .then(function(task) {
                    $mdDialog.hide(task);
                })
                .catch(function(response) {
                    if (response.status === 422) {
                        angular.forEach(response.data, function(value) {
                            angular.forEach(value, function(err) {
                                this.push(err);
                            }, this);
                        }, vm.errors);
                    } else {
                        vm.errors.push("An error occured on the server.");
                    }
                })
                .finally(function() {
                    vm.isLoading = false;
                });
        }

        function cancel() {
            $mdDialog.cancel();
        }
    }

})(window.angular);