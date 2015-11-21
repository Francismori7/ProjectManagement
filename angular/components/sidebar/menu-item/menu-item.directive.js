(function(angular) {
    'use strict';

    angular
        .module('creaperio.sidebar')
        .directive('menuItem', MenuItem);

    /* @ngInject */
    function MenuItem($compile, SidenavSvc) {
        return {
            restrict: 'E',
            scope: {
                icon: "@",
                title: "@",
                link: "@"
            },
            templateUrl: '/components/sidebar/menu-item/menu-item.html',
            link: function(scope, element) {
                element.on('click', function() {
                    SidenavSvc.toggleNav('navigation');
                });

                scope.$on("$destroy", function() {
                    element.off('click');
                });
            }
        };
    }

})(window.angular);
