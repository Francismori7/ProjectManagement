(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ShowTaskCtrl', ShowTaskCtrl);

    /* @ngInject */
    function ShowTaskCtrl($mdDialog, task) {
        console.log(task);
        var vm = this;

        vm.task = task;
        vm.cancel = cancel;
        vm.isLoading = false;

        function cancel() {
            $mdDialog.cancel();
        }
    }

})(window.angular);