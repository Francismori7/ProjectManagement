(function() {
    'use strict';

    angular
        .module('creaperio')
        .config(routerConfig);

        /** @ngInject */
        function routerConfig($stateProvider, $urlRouterProvider) {
            $stateProvider
                .state('app', {
                    abstract: true,
                    views: {
                        sidenav: {
                            templateUrl: getView('sidebar')
                        },
                        topnav: {
                            templateUrl: getView('topnav')
                        }
                    }
                })

                // Authentication States
                .state('app.auth', {
                    abstract: true,
                    url: '/auth',
                    views: {
                        'sidenav@': {},
                        'topnav@': {}
                    }
                })
                .state('app.auth.login', {
                    url: '/login',
                    views: {
                        'main@': {
                            templateUrl: getView('login', 'auth/login')
                        }
                    }
                })
                .state('app.auth.create', {
                    url: '/create',
                    views: {
                        'main@': {
                            templateUrl: getView('create', 'auth/create')
                        }
                    }
                })

                // Application States
                .state('app.dashboard', {
                    url: '/',
                    views: {
                        'main@': {
                            templateUrl: getView('dashboard')
                        }
                    }
                })

                // Project States
                .state('app.projects', {
                    url: '/projects',
                    views: {
                        'main@': {
                            templateUrl: getView('projects')
                        }
                    }
                })
                .state('app.projects.add', {
                    url: '/add',
                    onEnter: function($state, $mdDialog) {
                        $mdDialog.show({
                            controller: 'AddProjectCtrl',
                            controllerAs: 'vm',
                            templateUrl: getView('addproject', 'projects/add')
                        })
                        .finally(function() {
                            $state.go('app.projects');
                        });
                    }
                })
                .state('app.projects.show', {
                    url: '/:projectId',
                    abstract: true,
                    views: {
                        'main@': {
                            templateUrl: getView('showproject', 'projects/show')
                        }
                    }
                })
                .state('app.projects.show.general', {
                    url: '/general',
                    views: {
                        'tab@app.projects.show': {
                            templateUrl: getView('general', 'projects/show/general')
                        }
                    }
                })
                .state('app.projects.show.tasks', {
                    url: '/tasks',
                    views: {
                        'tab@app.projects.show': {
                            templateUrl: getView('tasks', 'projects/show/tasks')
                        }
                    }
                })
                .state('app.projects.show.members', {
                    url: '/members',
                    views: {
                        'tab@app.projects.show': {
                            templateUrl: getView('members', 'projects/show/members'),
                            controller: 'ShowProjectCtrl',
                            controllerAs: 'vm'
                        }
                    }
                })
                .state('app.projects.show.settings', {
                    url: '/settings',
                    views: {
                        'tab@app.projects.show': {
                            templateUrl: getView('settings', 'projects/show/settings')
                        }
                    }
                })

                // Client states
                .state('app.clients', {
                    url: '/clients',
                    views: {
                        'main@': {
                            templateUrl: getView('clients')
                        }
                    }
                })

                // Billing states
                .state('app.billing', {
                    url: '/billing',
                    views: {
                        'main@': {
                            templateUrl: getView('billing')
                        }
                    }
                });

            $urlRouterProvider.otherwise('/');

            function getView(name, baseFolder) {
                baseFolder = baseFolder || name;
                return '/components/' + baseFolder + '/' + name + '.html';
            }
        }

})();
