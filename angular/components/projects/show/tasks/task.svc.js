(function(angular) {
	'use strict';

	angular
		.module('creaperio.projects')
		.factory('TaskSvc', TaskSvc);

	/* @ngInject */
	function TaskSvc($q, ApiSvc, moment) {
		return {
			addTask: addTask
		};

		function addTask(project, task) {
			var deferred = $q.defer();

			console.log(task);

			ApiSvc.post('projects/' + project.id + '/tasks', task)
				.then(function(response) {
					deferred.resolve(response.data);
				})
				.catch(function(response) {
					deferred.reject({
						status: response.status,
						data: response.data
					});
				});

			return deferred.promise;
		}
	}

})(window.angular);