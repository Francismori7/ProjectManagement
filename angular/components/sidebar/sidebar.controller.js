(function() {
    'use strict';

    angular
        .module('creaperio.sidebar')
        .controller('SidebarCtrl', SidebarCtrl);

    /* @ngInject */
    function SidebarCtrl($scope, $element, SidenavSvc, scrollbar) {
        var vm = this;
        var scrollContainer = null;

        (function() {
            SidenavSvc.isMaximized(function(maximized) {
                vm.isMaximized = maximized;
            });

            scrollContainer = $element.children().first()[0];
            scrollbar.initialize(scrollContainer);
        })();

        $scope.$on("$destroy", function() {
            scrollbar.destroy(scrollContainer);
        });
    }
})();
