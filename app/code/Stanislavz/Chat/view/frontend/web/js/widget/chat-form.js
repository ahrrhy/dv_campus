define([
    'jquery',
    'Stanislavz_Chat/js/widget/chat-modal'
], function ($, chatModal) {
    'use strict';

    $.widget('stanislavzChat.chatFormWidget', {
        options: {
            action: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('submit.stanislavzChat', $.proxy(this.sendCustomerMessage, this));
        },

        _destroy: function () {
            $(this.element).off('submit.stanislavzChat');
            this.modal.destroy();
        },

        sendCustomerMessage: function () {
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
            var self = this,
                formData = new FormData($(this.element).get(0));

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

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    $(self.element).find('#customer_message').val('');
                    chatModal().renderMessage(response.message);
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your message can\'t be send right now.')
                    });
                }
            });
        },
    });

    return $.stanislavzChat.chatFormWidget;
});
