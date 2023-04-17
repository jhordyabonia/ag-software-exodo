require(['jquery', 'jquery/ui', 'slick'], function($) {
    $(document).ready(function() {
        $(".regular").slick({
            dots: true,
            customPaging: function(slider, i) {
                return (i % 3 === 0) ? '<button type="button" data-role="none"></button>' : '';
            },
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint:1280,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },

            ]
        });
    });
});

