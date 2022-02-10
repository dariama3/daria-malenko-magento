define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Dariam_RegularCustomer_submitFormAction',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, ko, Component, customerData, submitFormAction) {
    'use strict';

    return Component.extend({
        defaults: {
            action: null,
            alreadyRequested: false,
            customerName: '',
            customerEmail: '',
            isLoggedIn: false,
            isModal: false,
            productId: null,
            template: 'Dariam_RegularCustomer/form'
        },

        /**
         * Constructor
         */
        initialize: function () {
            this._super()

            this.updateFormState(customerData.get('regular-customer')());
            customerData.get('regular-customer').subscribe(this.updateFormState.bind(this));
        },

        /**
         * Initialize observables and subscribe to their change if needed
         * @returns {*}
         */
        initObservable: function () {
            this._super();
            this.observe(['alreadyRequested', 'customerName', 'customerEmail', 'isLoggedIn']);

            return this;
        },

        /**
         * Pre-fill form fields with data, hide fields if needed.
         * @param {Object} personalInfo
         */
        updateFormState: function (personalInfo) {
            if (personalInfo.productIds && personalInfo.productIds.includes(this.productId)) {
                return this.alreadyRequested(true);
            }

            if (personalInfo.name) {
                this.customerName(personalInfo.name);
            }

            if (personalInfo.email) {
                this.customerEmail(personalInfo.email);
            }

            this.isLoggedIn(!!personalInfo.isLoggedIn);
        },

        /**
         * Save current for element and initialize modal window
         * @param {Node} element
         */
        initModal: function (element) {
            this.$form = $(element);

            if (this.isModal) {
                this.$modal = this.$form.modal({
                    buttons: []
                });

                $(document).on('dariam_regular_customer_form_open', this.openModal.bind(this));
            }
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            this.$modal.modal('openModal');
        },

        /**
         * Validate form and send request
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return this.$form.validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let payload = {
                name: this.customerName(),
                email: this.customerEmail(),
                product_id: this.productId,
                form_key: $.mage.cookies.get('form_key'),
                isAjax: 1,
            };

            submitFormAction(this.action, payload)
                .done(() => {
                    if (this.isModal) {
                        this.$modal.modal('closeModal')
                    }
                });
        }
    });
});
