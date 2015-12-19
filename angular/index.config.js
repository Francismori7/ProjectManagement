(function() {
    'use strict';

    angular
        .module('creaperio')
        .config(config);

    /** @ngInject */
    function config($mdIconProvider, $localStorageProvider, $httpProvider) {
        $mdIconProvider
            .defaultFontSet('material-icons');

        $localStorageProvider.setKeyPrefix("creaperio_");

        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    }

})();
