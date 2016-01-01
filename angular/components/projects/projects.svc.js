(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .factory('ProjectsSvc', ProjectsSvc);

    /* @ngInject */
    function ProjectsSvc($q, ApiSvc) {
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
            var deferred = $q.defer();

            ApiSvc.get('projects/' + id)
                .then(function(response) {
                    console.log(response.data);
                    deferred.resolve(response.data);
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
                    deferred.resolve(response.data);
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
