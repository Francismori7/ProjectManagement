(function() {
    'use strict';

    angular
        .module('creaperio.common')
        .factory('ApiSvc', ApiSvc);

    /* @ngInject */
    function ApiSvc($http) {
        var baseUrl = '/api/v1/';

        return {
            get: getMethod,
            post: postMethod,
            put: putMethod,
            delete: deleteMethod
        };

        function getMethod(url, opts) {
            return query('GET', url, opts);
        }

        function postMethod(url, data, opts) {
            opts.data = data;
            return query('POST', url, opts);
        }

        function putMethod(url, data, opts) {
            opts.data = angular.merge({
                _method: 'PUT'
            }, data);

            return query('POST', url, opts);
        }

        function deleteMethod(url, opts) {
            opts.data = {
                _method: 'DELETE'
            };
            
            return query('POST', url, opts);
        }

        function query(method, url, options) {
            var opts = angular.merge({
                url: url,
                method: method
            }, options);

            return $http(opts);
        }
    }
})();
