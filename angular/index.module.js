(function() {
    'use strict';

    angular
        .module('creaperio', [
            'ngAnimate',
            'ngCookies',
            'ngTouch',
            'ngSanitize',
            'ngMessages',
            'ngAria',
            'ui.router',
            'ngMaterial',
            'toastr',

            'creaperio.sidebar',
            'creaperio.topnav',
            'creaperio.projects',
            'creaperio.clients',
            'creaperio.billing',
            'creaperio.dashboard'
        ]);

    angular.module('creaperio.common', ['ngMaterial']);
    angular.module('creaperio.sidebar', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.topnav', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.dashboard', ['ngMaterial']);
    angular.module('creaperio.projects', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.clients', ['ngMaterial', 'creaperio.common']);
    angular.module('creaperio.billing', ['ngMaterial', 'creaperio.common']);
})();
