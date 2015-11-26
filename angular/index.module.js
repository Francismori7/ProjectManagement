(function(angular) {
    'use strict';

    angular
        .module('creaperio', [
            'ngAnimate',
            'ngTouch',
            'ngSanitize',
            'ngMessages',
            'ngAria',
            'ui.router',
            'ngMaterial',
            'ngStorage',
            'toastr',

            'creaperio.sidebar',
            'creaperio.topnav',
            'creaperio.projects',
            'creaperio.clients',
            'creaperio.billing',
            'creaperio.auth.login',
            'creaperio.auth.create',
            'creaperio.dashboard'
        ]);

    angular.module('creaperio.common', ['ngStorage', 'ngMaterial']);
    angular.module('creaperio.sidebar', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.topnav', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.dashboard', ['ngMaterial']);
    angular.module('creaperio.projects', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.clients', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.billing', ['ngMaterial', 'creaperio.common']);

    angular.module('creaperio.auth.login', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.auth.create', ['ngMaterial', 'creaperio.common']);

})(window.angular);
