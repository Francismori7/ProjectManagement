(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('ProjectsCtrl', ProjectsCtrl);

    /* @ngInject */
    function ProjectsCtrl(ProjectsSvc, SidenavSvc) {
        var vm = this;

        vm.toggleSidebar = toggleSidebar;

        (function() {
            ProjectsSvc.getAll()
                .then(function(projects) {
                    console.log(projects);
                    vm.projects = projects;
                });
        })();

        function toggleSidebar() {
            SidenavSvc.toggleNav('module-sidebar');
        }
    }

})();
