(function(angular) {
    'use strict';

    angular
        .module('app.common')
        .factory('AuthService', AuthService);

    /* @ngInject */
    function AuthService($localStorage) {
        return {
            login: login,
            getToken: getToken,
            isAuthenticated: isAuthenticated,
            logout: logout
        };

        /**
         * Log a user into the application.
         *
         * @param {object} user
         */
        function login(user) {
            // Call api for token
            $localStorage.token = "someToken";
        }

        /**
         * Get the JSON Web Token.
         *
         * @return {string}
         */
        function getToken() {
            return $localStorage.token;
        }

        /**
         * Check wether someone is authenticated.
         *
         * @return {boolean}
         */
        function isAuthenticated() {
            return $localStorage.token !== null;
        }

        /**
         * Log a user out off the application.
         */
        function logout() {
            delete $localStorage.token;
        }
    }

})(window.angular);
