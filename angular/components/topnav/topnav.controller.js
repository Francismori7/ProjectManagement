(function() {
    'use strict';

    angular
        .module('creaperio.topnav')
        .controller('TopnavCtrl', TopnavCtrl);

    /* @ngInject */
    function TopnavCtrl(SidenavSvc, AuthSvc, $state) {
        var vm = this;

        vm.toggleNavigation = toggleNavigation;
        vm.minMaxNavigation = minMaxNavigation;
        vm.logout           = logout;

        (function() {
            SidenavSvc.isMaximized(function(maximized) {
                vm.isMaximized = maximized;
            });
        })();

        function toggleNavigation() {
            SidenavSvc.toggleNav('navigation');
        }

        function minMaxNavigation() {
            SidenavSvc.minMax();
        }

        function logout() {
            AuthSvc.logout();
            $state.go('app.auth.login');
        }
    }

})();
