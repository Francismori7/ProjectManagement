(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ProjectTaskCtrl', ProjectTaskCtrl);

    /* @ngInject */
    function ProjectTaskCtrl($scope, $mdDialog) {
        var vm = this;

        vm.addTask = addTask;
        vm.openTaskDialog = openTaskDialog;

        function addTask(ev) {
            $mdDialog.show({
                controller: 'AddTaskCtrl',
                controllerAs: 'vm',
                templateUrl: '/components/projects/show/tasks/add/addtask.html',
                targetEvent: ev,
                locals: {project: $scope.project}
            }).then(function(task) {
                $scope.project.tasks.unshift(task);
            });
        }

        function openTaskDialog(ev, task) {
            $mdDialog.show({
                controller: 'ShowTaskCtrl',
                controllerAs: 'vm',
                templateUrl: '/components/projects/show/tasks/show/showtask.html',
                targetEvent: ev,
                locals: {task: task, employees: $scope.project.users}
            }).then(function(task) {

            });
        }
    }

})(window.angular);
