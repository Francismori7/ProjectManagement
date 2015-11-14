(function() {
    'use strict';

    angular
        .module('creaperio')
        .config(config);

    /** @ngInject */
    function config($mdIconProvider) {
        $mdIconProvider
            .defaultFontSet('material-icons');
    }

})();
