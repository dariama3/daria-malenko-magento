define([
    'jquery',
    'uiComponent',
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Dariam_RegularCustomer/form-open-button'
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('dariam_regular_customer_form_open');
        }
    });
});
