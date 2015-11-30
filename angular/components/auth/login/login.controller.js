(function(angular) {
    'use strict';

    angular
        .module('creaperio.auth.login')
        .controller('LoginCtrl', LoginCtrl);

    /* @ngInject */
    function LoginCtrl(AuthSvc, $state) {
        var vm = this;

        vm.login = login;
        vm.errors = [];
        vm.isLoading = false;

        function login(user) {
            toggleIsLoading();
            AuthSvc.login(user)
        		.then(function() {
        			$state.go('app.dashboard');
        		})
        		.catch(function() {
                    vm.errors = ["Invalid Credentials"];
        		})
                .finally(function() {
                    toggleIsLoading();
                });
        }

        function toggleIsLoading() {
            vm.isLoading = !vm.isLoading;
        }
    }

})(window.angular);
