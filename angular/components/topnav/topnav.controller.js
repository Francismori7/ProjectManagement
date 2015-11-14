(function() {
    'use strict';

    angular
        .module('creaperio.topnav')
        .controller('TopnavCtrl', TopnavCtrl);

    /* @ngInject */
    function TopnavCtrl(SidenavSvc) {
        var vm = this;

        vm.toggleNavigation = toggleNavigation;
        vm.minMaxNavigation = minMaxNavigation;

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
    }

})();
