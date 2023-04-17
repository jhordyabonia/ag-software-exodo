jQuery(function($) {

    const viewedClear = $('#viewed-clear');

    const recentlyViewed = $('#recently-viewed');

    function viewedClearAll () {

        recentlyViewed.html("");

    }

    viewedClear.on('click', viewedClearAll);


});
