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
                    deferred.resolve(response.data);
                })
                .catch(function(response) {
                    deferred.reject("An error occured.");
                });

            return deferred.promise;
        }

        function get(id) {
            for (var i = 0; i < projects.length; i++) {
                if (projects[i].id == id)
                    return $q.resolve(projects[i]);
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

            ApiSvc.post('projects', project || {})
                .then(function(response) {
                    projects.unshift(response.data.project);
                    deferred.resolve(response.data.project);
                })
                .catch(function(response) {
                    var errors;

                    if (response.status !== 422) {
                        errors = ["An error occured on the server."];
                    } else {
                        errors = angular.forEach(response.data, function(value, key) {
                            angular.forEach(value, function(err, index) {
                                this.push(err);
                            }, this);
                        }, []);
                    }

                    deferred.reject({
                        status: response.status,
                        errors: errors
                    });
                });

            return deferred.promise;
        }
    }

})(window.angular);
