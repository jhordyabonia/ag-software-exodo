jQuery(function($) {

    $(document).ready(function() {
        var viewed = $('#viewed');
        var modal = $('#viewed-modal');

        function viewedModal() {
            if ( modal.hasClass('viewed-modal--active') ) {
                modal.addClass('slideOutDownModal');
                modal.removeClass('slideInUpModal');
                setTimeout(function() {
                    modal.removeClass('viewed-modal--active');
                    modal.addClass('viewed-modal--inactive');
                }, 500);
            } else {
                modal.addClass('slideInUpModal');
                modal.removeClass('slideOutDownModal');
                setTimeout(function() {
                    modal.addClass('viewed-modal--active');
                    modal.removeClass('viewed-modal--inactive');
                }, 500);
            }
        }

        viewed.click(viewedModal);
    });


});
