define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Checkout/js/model/totals',
    'uiComponent',
    'Magento_Checkout/js/action/select-shipping-method',
    'mage/translate',
    'mage/url',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/checkout-data',
    'Magento_Checkout/js/model/full-screen-loader',
    'AgSoftware_StorePickup/js/model/storepickup-data',
    'Magento_Catalog/js/price-utils',
    'AgSoftware_StorePickup/js/model/google-map'
], function ($, modal, Totals, Component, selectShippingMethodAction, $t, url, totalsDefaultProvider, quote, checkoutData, fullScreenLoader, storepickupData, Calc,googleMap) {
    'use strict';

    return Component.extend({
        defaults: {
            storePickupActive: window.checkoutConfig.storepickup.loadedStores.active,
            template: 'AgSoftware_StorePickup/checkout',
            storePickupSelected: storepickupData.storePickupSelected,
            selectedStore: storepickupData.selectedStore,
            filters: storepickupData.filters,
            isValid: storepickupData.isValid,
            store:null,
            modal:null
        },
        stores : storepickupData.stores,
        loading : storepickupData.loadingStores,

        initialize: function () {
            this._super();
            let _self = this;

            if(!_self.storePickupActive){
                return;
            }
            quote.shippingMethod.subscribe(function (ev) {
                try {
                    if(ev) {
                        _self.storePickupSelected(ev.carrier_code == "store_pickup"
                            && ev.method_code == "store_pickup");
                        if(_self.storePickupSelected()){
                            _self.loadStores();
                            _self.isValid(false);
                        }else{
                            this.makePopup();
                            _self.isValid(true);
                        }
                        if(!$('[value="store_pickup_store_pickup"]').attr('launch-popup')) {
                            $('[value="store_pickup_store_pickup"]').closest('tr').on('click', () => {
                                _self.launchPopup();
                            });
                            $('[value="store_pickup_store_pickup"]').attr('launch-popup',1);
                            googleMap.startMap();
                        }
                    }else{
                        _self.storePickupSelected(false);
                    }
                }catch(e) {
                    console.error(e);
                }
            }, _self);

            _self.selectedStore.subscribe(function (ev){
                _self.stores.each((element) => {
                    if (element.store_pickup_id == ev) {
                        _self.store = element;
                        _self.selectStore();
                        return;
                    }
                });
            },_self);

            _self.isValid.subscribe((e)=>{
                if(_self.storePickupSelected()){
                    let span='',td = $('[value="store_pickup_store_pickup"]').closest('tr').find('td.col.col-carrier');
                    $('#store-pickup-info').remove();
                    if(e) {
                        $('.checkout-shipping-method .actions-toolbar [type="submit"].primary').attr('disabled',false);
                        span = $('<span id="store-pickup-info"><br/><br/>'+$t('La tienda seleccionada es: ')+(_self.getStore().name)+'</span>');
                    }else{
                        $('.checkout-shipping-method .actions-toolbar [type="submit"].primary').attr('disabled',true);
                        span = $('<span id="store-pickup-info" classs="red"><br/><br/>'+$t('Seleccionar tienda aquí')+'</span>');
                    }
                    td.append(span,td);
                }else{
                    $('#store-pickup-info').remove();
                    $('.checkout-shipping-method .actions-toolbar [type="submit"].primary').attr('disabled',false);
                }
            },_self);

            _self.filters.subscribe(function (ev){
                _self.loadStores();
            },_self);

            googleMap.prepare();
            return this;
        },
        getStore: function(){
            if(this.selectedStore()) {
                return this.store;
            }
            return false;
        },
        loadStores : function() {

            let region = $('[name="region_id"]').val(), index = 0, stores = [], showAll = this.filters(),
                tmp_stores = window.checkoutConfig.storepickup.loadedStores.storeslist;

            if(tmp_stores.length == 0){
                return;
            }

            for (const key in tmp_stores) {
                if (showAll) {
                    stores[key] = tmp_stores[key];
                } else if (tmp_stores[key].hasOwnProperty('departamento') && tmp_stores[key]['departamento'] == region) {
                    stores[index++] = tmp_stores[key];
                }
            }

            this.stores(stores);
            this.makePopup();
        },
        launchPopup:function(){
            let self = this;
            setTimeout(()=>{
                self.isValid(false);
                $('.storepickup-list-wrapper [name="list-stores"]').val('').trigger('change');
                $('.storepickup-list-wrapper').modal('openModal');
            },100);
        },
        makePopup:function(){
            if(this.modal){
                return;
            }
            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                clickableOverlay: false,
                modalClass: 'wrap-modal-flex',
                title: '',
                buttons: [{
                    text: $.mage.__('Seleccionar'),
                    class: 'action primary btn-popup-store-pickup'
                }]
            };

            this.modal = modal(options, $('.storepickup-list-wrapper'));
        },
        isActive:function() {
            return this.storePickupSelected();
        },
        fullAddress: function(){
            let store = this.getStore();
            if(store && store.store_pickup_id) {
                return '<address>' + store.street + ', ' + store.distrito_n + '<br/> ' +
                    store.provincia_n + ' ' + store.departamento_n + ', ' + store.country_id +
                    (store.email ? '<br/>correo: ' + store.email : '') +
                    (store.telephone ? '<br/>tel: ' + store.telephone : '') +
                    '</address>';
            }else{
                return '';
            }
        },
        /**
         * Set Store on system-cache
         * $this->dataPersistor->get('store_pickup')
         * @param store
         */
        selectStore: function () {
            let store = this.store,self = this;
            if (store != null && store.store_pickup_id){
                fullScreenLoader.startLoader();
                $.ajax({
                    url: url.build("storepickup/checkout/selectstore"),
                    type: "post",
                    dataType: "json",
                    data: {
                        store_pickup: store.store_pickup_id
                    },
                    success: function (result) {
                        fullScreenLoader.stopLoader();
                        if(result === true){
                            self.isValid(true);
                        }else{
                            self.isValid(false);
                        }
                    },
                    error: function(response){
                        fullScreenLoader.stopLoader();
                        self.isValid(false);
                    }
                });
            }
        }

    });
});
