(function() {
    'use strict';

    angular
        .module('creaperio')
        .config(config);

    /** @ngInject */
    function config($mdIconProvider, $localStorageProvider) {
        $mdIconProvider
            .defaultFontSet('material-icons');

        $localStorageProvider.setKeyPrefix("creaperio");
    }

})();
