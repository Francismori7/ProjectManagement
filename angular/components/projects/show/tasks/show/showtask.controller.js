(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ShowTaskCtrl', ShowTaskCtrl);

    /* @ngInject */
    function ShowTaskCtrl($mdDialog, task, employees, moment) {
        var vm = this;

        task.due_at = moment(task.due_at).toDate();
        vm.task = task;
        vm.employees = employees;
        vm.cancel = cancel;
        vm.isLoading = false;

        function cancel() {
            $mdDialog.cancel();
        }
    }

})(window.angular);
