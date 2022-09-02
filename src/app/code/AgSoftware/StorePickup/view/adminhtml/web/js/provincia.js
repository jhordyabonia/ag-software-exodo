define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select',
    'mage/url'
], function (_, uiRegistry, select,Url) {
    'use strict';

    return select.extend({

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {

            var fieldCountry = uiRegistry.get('index = country_id');
            var url = Url.build('/admin/agsoftware/storepickup/data/');
            var request = {
                method:'POST',
                headers:{'Content-Type': 'application/json'},
                body:JSON.stringify({'distrito':value,'country':fieldCountry.value()})
            };
            uiRegistry.get('index = provincia').value(value);

            fetch(url,request).then((result)=>{
                var fieldDistrito = uiRegistry.get('index = distrito_select');
                console.log(fieldDistrito)
                if(result.ok){
                     result.json().then((resultJSON)=>{
                        fieldDistrito.options(resultJSON);
                    });
                }
            }).catch((error)=>{
            });

            return this._super();
        },
    });
});
