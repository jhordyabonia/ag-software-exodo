jQuery(function($) {

    const pageHeader = $('.page-header');
    const pageMain = $('.page-main');

    function headerDinamic () {
        if ($(window).scrollTop() > 0) {
            pageHeader.css('position', 'fixed');
            pageMain.css('margin-top', '153px');
        } else {
            pageHeader.css('position', 'relative');
            pageMain.css('margin-top', '0');
        }
    }

    $(window).on('scroll', headerDinamic);

});
