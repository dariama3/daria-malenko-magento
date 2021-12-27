define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('Dariam.regularCustomer_formOpenButton', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('dariam_regular_customer_form_open');
        }
    });

    return $.Dariam.regularCustomer_formOpenButton;
});
