define([
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote'
], function (ko, Component, quote) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'RecruitmentTasks_OrderNote/checkout/custom-order-note'
        },
        customOrderNote: ko.observable(''),

        initialize: function () {
            this._super();
            this.customOrderNote.subscribe(function (value) {
                var shippingAddress = quote.shippingAddress();
                if (shippingAddress) {
                    if (!shippingAddress.extensionAttributes) {
                        shippingAddress.extensionAttributes = {};
                    }
                    shippingAddress.extensionAttributes.custom_order_note = value;
                }
            });
            return this;
        }
    });
});
