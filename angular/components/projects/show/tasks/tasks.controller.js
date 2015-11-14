(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ShowProjectCtrl', ShowProjectCtrl);

    /* @ngInject */
    function ShowProjectCtrl($stateParams, ProjectsSvc) {
        var vm = this;

        (function() {
            vm.project = ProjectsSvc.get($stateParams.projectId);
        })();
    }

})();
