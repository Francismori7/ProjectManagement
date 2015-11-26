(function(angular) {
    'use strict';

    angular
        .module('creaperio.auth.login')
        .controller('LoginCtrl', LoginCtrl);

    /* @ngInject */
    function LoginCtrl() {
        var vm = this;

        vm.login = login;

        function login(user) {
        	AuthSvc.login(user)
        		.then(function() {
        			
        		})
        		.catch(function(errors) {
        			
        		});
        }
    }

})(window.angular);
