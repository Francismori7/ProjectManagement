(function(angular) {
    'use strict';

    angular
        .module('creaperio.auth.create')
        .controller('CreateCtrl', CreateCtrl);

    /* @ngInject */
    function CreateCtrl(AuthSvc) {
        var vm = this;

        vm.register = register;

        function register(user) {
        	AuthSvc.register(user)
        		.then(function() {
        			
        		})
        		.catch(function(errors) {
        			
        		});
        }
    }

})(window.angular);
