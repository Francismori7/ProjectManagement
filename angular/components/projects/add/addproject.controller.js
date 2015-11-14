(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('AddProjectCtrl', AddProjectsCtrl);

    /* @ngInject */
    function AddProjectsCtrl($mdDialog, ProjectsSvc) {
        var vm = this;

        vm.cancel      = cancel;

        vm.project     = {todos: [], assignees: []};
        vm.todoName    = '';

        vm.addTodoItem     = addTodoItem;
        vm.handleTodoEnter = handleTodoEnter;
        vm.addProject      = addProject;

        function addTodoItem() {
            vm.project.todos.push({
                name: vm.todoName,
                complete: false
            });

            vm.todoName = '';
        }

        function handleTodoEnter(ev) {
            if (ev.keyCode === 13) {
                ev.preventDefault();

                if (vm.todoName !== '')
                    addTodoItem();
            }
        }

        function addProject() {
            ProjectsSvc.create(vm.project);
            $mdDialog.hide();
        }

        function cancel() {
            $mdDialog.cancel();
        }
    }

})();
