$(document).ready(function () {
    var menuToggle = $('#js-navigation-mobile-menu').unbind();
    $('#js-navigation-menu').removeClass("show");

    menuToggle.on('click', function (e) {
        e.preventDefault();
        $('#js-navigation-menu').slideToggle(function () {
            var $jsNavigationMenu = $('#js-navigation-menu');

            if ($jsNavigationMenu.is(':hidden')) {
                $jsNavigationMenu.removeAttr('style');
            }
        });
    });
});
