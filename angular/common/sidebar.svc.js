(function() {
    'use strict';

    angular
        .module('creaperio.common')
        .factory('SidenavSvc', SidenavSvc);

    /* @ngInject */
    function SidenavSvc($mdSidenav) {
        var maximized     = true;
        var resizeActions = [];

        return {
            toggleNav: toggleNav,
            minMax: minMax,
            isMaximized: isMaximized
        };

        function toggleNav(componentId) {
            return $mdSidenav(componentId).toggle();
        }

        function minMax() {
            maximized = !maximized;

            for (var action in resizeActions)
                resizeActions[action].call(undefined, maximized);
        }

        function isMaximized(action) {
            resizeActions.push(action);

            action.call(undefined, maximized);
        }
    }

})();
