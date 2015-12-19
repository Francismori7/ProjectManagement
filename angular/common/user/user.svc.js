(function(angular) {
    'use strict';

    angular
        .module('creaperio.common')
        .factory('UserSvc', UserSvc);

    /* @ngInject */
    function UserSvc() {
        return {
            getUserFromId: getUserFromId,
            getNameFromUser: getNameFromUser
        };

        function getUserFromId(id, project) {
            if (id === undefined)
                return {};

            var i, users = project.users;
            
            for (i = 0; i < users.length; i++) {
                if (users[i].id === id)
                    return users[i];
            }

            return null;
        }

        function getNameFromUser(user) {
            if (user === null || user.first_name === undefined)
                return "Loading...";

            return user.first_name + " " + user.last_name;
        }
    }
})(window.angular);
