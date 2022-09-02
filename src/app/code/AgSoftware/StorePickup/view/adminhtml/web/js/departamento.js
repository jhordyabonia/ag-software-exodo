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

            var fieldProvincia = uiRegistry.get('index = provincia_select');
            var fieldCountry = uiRegistry.get('index = country_id');
            var url = Url.build('/admin/agsoftware/storepickup/data/');
            var request = {
                method:'POST',
                headers:{'Content-Type': 'application/json'},
                body:JSON.stringify({'provincia':value,'country':fieldCountry.value()})
            };

            uiRegistry.get('index = departamento').value(value);
            fetch(url,request).then((result)=>{
                if(result.ok){
                     result.json().then((resultJSON)=>{
                        fieldProvincia.options(resultJSON);
                    });
                }
            }).catch((error)=>{
            });

            return this._super();
        },
    });
});
