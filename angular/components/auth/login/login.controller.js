(function(angular) {
    'use strict';

    angular
        .module('creaperio.auth.login')
        .controller('LoginCtrl', LoginCtrl);

    /* @ngInject */
    function LoginCtrl(LoginSvc) {
        var vm = this;

        vm.login = login;
        vm.errors = [];
        vm.isLoading = false;

        function login(user) {
            vm.isLoading = true;
            LoginSvc.login(user)
        		.then(function() {
        		})
        		.catch(function() {
                    vm.errors = ["Invalid Credentials"];
        		})
                .finally(function() {
                    vm.isLoading = false;
                });
        }
    }
})(window.angular);
