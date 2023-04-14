require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function($,modal) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Custom Form Popup',
            buttons: [{
                text: $.mage.__('Close'),
                class: 'modal-close',
                click: function (){
                    this.closeModal();
                }
            }]
        };

        modal(options, $('#popup-modal'));
        $("#modal-btn").on('click',function(){
            $("#popup-modal").modal("openModal");
        });
    }
);