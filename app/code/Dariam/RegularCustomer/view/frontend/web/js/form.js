define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, customerData, alert) {
    'use strict';

    $.widget('Dariam.regularCustomer_form', {
        options: {
            action: '',
            checkUrl: '',
            isModal: false
        },

        /**
         * @property {string} data.name
         * @property {string} data.email
         * @property {array} data.productIds
         * @property {boolean} data.isLoggedIn
         * @private
         */
        _create: function () {
            $(this.element).on('submit.dariam_regular_customer_form', this.sendRequest.bind(this));

            if (this.options.isModal) {
                $(this.element).modal({
                    buttons: []
                });

                $(document).on('dariam_regular_customer_form_open', this.openModal.bind(this));
            }

            this.updateFormState(customerData.get('regular-customer')());
            customerData.get('regular-customer').subscribe(this.updateFormState.bind(this));
        },

        /**
         * Pre-fill form fields with data, hide fields if needed.
         */
        updateFormState: function (personalInfo) {
            const nameField = $('input[name="name"]', this.element);
            const emailField = $('input[name="email"]', this.element);
            const productField = $('input[name="product_id"]', this.element);
            const productId = Number(productField.val());

            if (personalInfo.productIds.includes(productId)) {
                return this.showAlreadyRequested();
            }
            if (personalInfo.name) {
                nameField.val(data.name);
            }
            if (personalInfo.email) {
                emailField.val(data.email);
            }
            if (personalInfo.isLoggedIn) {
                nameField.parent('field').hide();
                emailField.parent('field').hide();
            }
        },

        /**
         * Hide form and show already-requested message.
         */
        showAlreadyRequested: function () {
            $(this.element).addClass('form--hidden');
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            $(this.element).modal('openModal');
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
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let formData = new FormData($(this.element).get(0));

            // Form key is not appended when the form is in the tab. Must add it manually
            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /**
                 * Success means that response from the server was received, but not that the request was saved!
                 *
                 * @inheritdoc
                 */
                success: function (response) {
                    alert({
                        title: $.mage.__('Posting your request...'),
                        content: response.message
                    });

                    this.showAlreadyRequested();
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__("Your request can't be sent. Please, contact us if you see this message.")
                    });
                },

                /** @inheritdoc */
                complete: function () {
                    if (this.options.isModal) {
                        $(this.element).modal('closeModal');
                    }

                    $('body').trigger('processStop');
                }
            });
        }
    });

    return $.Dariam.regularCustomer_form;
});
