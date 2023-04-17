jQuery(function($) {

    const chevronTops = $('.chevron-top');

    function chevronScrollTop() {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    }

    chevronTops.on('click', chevronScrollTop);

});
