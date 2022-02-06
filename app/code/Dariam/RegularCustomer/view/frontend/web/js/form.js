define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, alert) {
    'use strict';

    $.widget('Dariam.regularCustomer_form', {
        options: {
            action: '',
            checkUrl: '',
            isModal: false
        },

        /**
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

            this.checkProduct();
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
        },

        checkProduct: function () {
            if (!this.options.checkUrl) return;

            const formData = new FormData($(this.element).get(0));
            const productId = formData.get('product_id');

            fetch(this.options.checkUrl)
                .then((response) => response.json())
                .then((data) => {
                    if (data.products.some((id) => String(id) === String(productId))) {
                        this.showAlreadyRequested();
                    }
                })
        },

        showAlreadyRequested: function () {
            $(this.element).replaceWith('<span>Already Requested!</span>');
        }
    });

    return $.Dariam.regularCustomer_form;
});
