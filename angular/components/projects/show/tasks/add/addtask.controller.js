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
            TaskSvc.addTask(project, task)
                .then(function(task) {
                    $mdDialog.hide(task);
                })
                .catch(function(response) {
                    console.log(response);
                });
        }

        function cancel() {
            $mdDialog.cancel();
        }
    }

})(window.angular);