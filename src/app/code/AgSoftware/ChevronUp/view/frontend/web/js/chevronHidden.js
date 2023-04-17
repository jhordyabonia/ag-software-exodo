jQuery(function($) {

    const chevronButton = $('#chevronButton');

    function chevronHidden() {
        if ($(window).scrollTop() <= 359) {
            chevronButton.addClass('chevron--hidden');
        } else {
            chevronButton.removeClass('chevron--hidden');
        }
    }

    $(window).on('scroll', chevronHidden);

});
