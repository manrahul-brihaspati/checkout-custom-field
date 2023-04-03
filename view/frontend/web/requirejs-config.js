var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Tbi_CheckoutCustomField/js/action/set-shipping-information-mixin': true
            }
        }
    },
    "map" : {
        "*" : {
            "Magento_Checkout/js/action/set-shipping-information.js" : "Tbi_CheckoutCustomField/js/set-shipping-information"
        }
    }
};
