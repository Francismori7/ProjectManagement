(function(angular) {
    'use strict';

    angular
        .module('creaperio.auth.create')
        .controller('CreateCtrl', CreateCtrl);

    /* @ngInject */
    function CreateCtrl($state, RegisterSvc) {
        var vm = this;

        vm.register = register;
        vm.isLoading = false;
        vm.errors = [];

        function register(user) {
            vm.isLoading = true;
        	RegisterSvc.register(user)
        		.then(function() {
        			$state.go('app.dashboard');
        		})
        		.catch(function(response) {
                    var errors = [];
        			if (response.status === 422) {
                        // Need to clean this up
                        angular.forEach(response.data, function(value, key) {
                            angular.forEach(value, function(value, key) {
                                this.push(value);
                            }, this);
                        }, errors);
                    } else {
                        errors.push("An error occured on the server.");
                    }

                    vm.errors = errors;
        		})
                .finally(function() {
                    vm.isLoading = false;
                });
        }
    }

})(window.angular);
