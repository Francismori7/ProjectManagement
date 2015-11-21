(function() {
    'use strict';

    angular
        .module('creaperio.projects')
        .factory('ProjectsSvc', ProjectsSvc);

    /* @ngInject */
    function ProjectsSvc($q, ApiSvc) {
        var _projects = [
            {
                id: 1445436541221,
                title: 'Creaperio',
                progress: 63,
                projectLeader: 1,
                tasks: [
                    {
                        title: "Fix Projects",
                        assignee: 1
                    },
                    {
                        title: "Add Billing",
                        assignee: 1
                    },
                    {
                        title: "Support PayPal and Stripe (creditcard)",
                        assignee: 2
                    },
                    {
                        title: "Add Clients",
                        assignee: 1
                    }
                ],
                assignees: [
                    {
                        id: 1,
                        name: 'Maarten Flippo',
                        position: 'Lead Developer'
                    },
                    {
                        id: 2,
                        name: 'Francis Mori',
                        position: 'Backend Developer'
                    },
                ]
            },
            {
                id: 1445436541221 - 126548,
                title: 'GamesJobFinder',
                progress: 52,
                projectLeader: {
                    id: 1,
                    username: 'muukrls'
                },
                tasks: [],
                assignees: []
            },
            {
                id: 1445436541221 - 4545887,
                title: 'Pizza App',
                progress: 29,
                projectLeader: {
                    id: 2,
                    username: 'Tim'
                },
                tasks: [],
                assignees: []
            }
        ];

        return {
            getAll: getAll,
            get: get,
            create: create
        };

        function getAll() {
            return $q.resolve(_projects);
        }

        function get(id) {
            for (var i = 0; i < _projects.length; i++) {
                if (_projects[i].id == id)
                    return _projects[i];
            }

            return null;
        }

        function create(project) {
            project.id = new Date().getTime();
            _projects.unshift(project);
        }
    }
})();
