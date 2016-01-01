(function(angular) {
    'use strict';

    angular
        .module('creaperio.projects')
        .controller('GeneralProjectDetailCtrl', GeneralProjectDetailCtrl);

    /* @ngInject */
    function GeneralProjectDetailCtrl() {
		var vm = this;

		vm.getCompletePercentage = getCompletePercentage;

		function getCompletePercentage(project) {
			if (!project)
				return 0;
			return (project.completedTasks.length || 0) / (project.tasks.length || 0) * 100;
		}        
    }

})(window.angular);
