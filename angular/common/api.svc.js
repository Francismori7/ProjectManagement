(function(angular) {
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
            patch: patchMethod,
            delete: deleteMethod
        };

        function getMethod(url, opts) {
            return query('GET', url, opts);
        }

        function postMethod(url, data, opts) {
            opts = opts || {};
            opts.data = data;
            return query('POST', url, opts);
        }

        function patchMethod(url, data, opts) {
            opts = opts || {};
            opts.data = angular.merge({
                _method: 'PATCH'
            }, data);

            return query('POST', url, opts);
        }

        function deleteMethod(url, opts) {
            opts = opts || {};
            opts.data = {
                _method: 'DELETE'
            };
            
            return query('POST', url, opts);
        }

        function query(method, url, options) {
            var opts = angular.merge({
                url: baseUrl + url,
                method: method
            }, options);

            return $http(opts);
        }
    }
})(window.angular);
