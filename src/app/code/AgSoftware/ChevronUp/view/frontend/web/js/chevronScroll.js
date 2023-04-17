jQuery(function($) {

    const chevronUp = $('#chevronUp');

    function chevronScrollUp() {
        $('html').scrollTop();
        if ($('html').scrollTop() > 0) {
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        }
    }

    chevronUp.on('click', chevronScrollUp);

});
