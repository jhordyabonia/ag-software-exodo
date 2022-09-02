define([
    'ko'
],
function(
    ko
) {
    'use strict';
    return {
        storePickupSelected: ko.observable(false),
        selectedStore: ko.observable(null),
        stores: ko.observableArray([]),
        loadingStores : ko.observable(false),
        filters : ko.observable(false),
        isValid : ko.observable(false)
    };
});
