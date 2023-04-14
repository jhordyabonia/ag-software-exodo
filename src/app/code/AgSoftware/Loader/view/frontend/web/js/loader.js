require(['jquery', 'loader'], function($) {
    $(window).on('load', function() {
       /* console.log('La página ha cargado completamente.');*/
        $('#loader').fadeOut();
        /*console.log('El widget Loader se ha ocultado.');*/
    });
});
