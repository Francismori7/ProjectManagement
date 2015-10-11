(function(angular) {
    'use strict';

    angular
        .module('creaperio')
        .config(Config);

    /* @ngInject */
    function Config($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('app', {
                abstract: true,
                views: {
                    navigation: {
                        templateUrl: getView('navigation'),
                        controller: 'NavigationCtrl',
                        controllerAs: 'vm'
                    }
                }
            })

            .state('app.login', {
                url: '/',
                views: {
                    //'navigation@': {},
                    'sidebar@': {},
                    'main@': {
                        templateUrl: getView('login'),
                        controller: 'LoginCtrl',
                        controllerAs: 'vm'
                    }
                }
            })

            // Project States
            .state('app.projects', {
                abstract: true,
                url: '/projects',
                views: {
                    'sidebar@': {

                    }
                }
            });

        $urlRouterProvider.otherwise('/');

        function getView(name) {
            return '/views/app/' + name + '/' + name + '.html';
        }
    }

})(window.angular);
