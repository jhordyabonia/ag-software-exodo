
  jQuery(function($) {
    $('a[data-scroll]').on('click', function(event) {
        var target = $($(this).attr('data-scroll-target'));
        if (target.length) {
          event.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
        }
      });
  });