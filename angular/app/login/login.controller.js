(function(angular) {

    'use strict';

    angular
        .module('app.login')
        .controller('LoginCtrl', LoginCtrl);

    /* @ngInject */
    function LoginCtrl() {
        var vm = this;

        vm.user = {};

        vm.login = function() {
            
        };
    }

})(window.angular);
