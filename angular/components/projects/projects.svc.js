(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .factory('ProjectsSvc', ProjectsSvc);

    /* @ngInject */
    function ProjectsSvc($q, ApiSvc) {
        var projects = [];

        return {
            getAll: getAll,
            get: get,
            create: create
        };

        function getAll() {
            var deferred = $q.defer();

            ApiSvc.get('projects')
                .then(function(response) {
                    console.log(response.data);
                    deferred.resolve(response.data.projects);
                })
                .catch(function(response) {
                    deferred.reject("An error occured.");
                });

            return deferred.promise;
        }

        function get(id) {
            for (var i = 0; i < _projects.length; i++) {
                if (_projects[i].id == id)
                    return $q.resolve(_projects[i]);
            }

            var deferred = $q.defer();

            ApiSvc.get('projects/' + id)
                .then(function(response) {
                    deferred.resolve(response.data.project);
                })
                .catch(function(response) {
                    deferred.reject();
                });

            return deferred.promise;
        }

        function create(project) {
            var deferred = $q.defer();

            ApiSvc.post('projects', project)
                .then(function(response) {
                    _projects.unsift(response.data.project);
                    deferred.resolve(response.data.project);
                });

            return deferred.promise;
        }
    }

})(window.angular);
