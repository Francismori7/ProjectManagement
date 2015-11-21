(function(moment, scrollbar) {
    'use strict';

    angular
        .module('creaperio')
        .constant('moment', moment)
        .constant('scrollbar', scrollbar);

})(window.moment, window.Ps);
