jQuery(function($) {

    $(document).ready(function() {
        var viewed = $('#viewed');
        var modal = $('#viewed-modal');
        const recentlyViewed = $('#recently-viewed');

        function viewedModal() {

            if ( modal.hasClass('viewed-modal--active') ) {
                recentlyViewed.addClass('animated');
                recentlyViewed.addClass('slideOutDownModal');
                recentlyViewed.removeClass('slideInUpModal');
                setTimeout(function() {
                    modal.removeClass('viewed-modal--active');
                    modal.addClass('viewed-modal--inactive');
                }, 500);
            } else {
                recentlyViewed.addClass('slideInUpModal');
                recentlyViewed.removeClass('slideOutDownModal');
                modal.addClass('viewed-modal--active');
                modal.removeClass('viewed-modal--inactive');
                /*setTimeout(function() {
                    modal.addClass('viewed-modal--active');
                    modal.removeClass('viewed-modal--inactive');
                }, 500);*/
            }

        }

        viewed.click(viewedModal);

    });

});
