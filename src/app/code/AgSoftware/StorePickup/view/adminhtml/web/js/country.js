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

            var fieldDepartamento = uiRegistry.get('index = departamento');
            var url = Url.build('/admin/agsoftware/storepickup/data/');
            var request = {
                method:'POST',
                headers:{'Content-Type': 'application/json'},
                body:JSON.stringify({'country':value})
            };

            fetch(url,request).then((result)=>{
                console.log(result)
                if(result.ok){
                     result.json().then((resultJSON)=>{

                         console.log(fieldDepartamento.options(),resultJSON);
                         fieldDepartamento.options(resultJSON);
                    });
                }
            }).catch((error)=>{
            });

            return this._super();
        },
    });
});
