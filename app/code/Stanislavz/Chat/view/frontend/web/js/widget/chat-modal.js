define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    $.widget('stanislavzChat.chatModal', {
        options: {
            chatModalInitButton: '.chat-initial',
            messageList: '#message-wrapper ul.message-list'
        },

        /**
         * @private
         */
        _create: function () {
            var self = this;
            this.modal = $(this.element).modal({
                type: 'popup',
                responsive: true,
                innerScroll: true,
                modalClass: 'modal-content chat-wrapper',
                header: '',
                closed: function (e) {
                    $(self.options.chatModalInitButton).trigger('stanislavz_Chat_closeChat.stanislavz_Chat');
                },
                title: '',
                buttons: []
            });
        },

        /**
         * @private
         */
        _destroy: function () {
            $(document).off('stanislavz_Chat_openChat.stanislavzChat');
            this.clearMessageList();
        },

        /**
         * @param {object} message
         */
        renderMessage: function (message) {
            var $message = $('<p>').addClass('message').text(message.message);
            var $name = $('<p>').addClass('name').text(message.name);
            var $time = $('<p>').addClass('time').text(message.time);
            var $messageItem = $('<li>').addClass('message-item');
            $messageItem.addClass(message.role);
            $messageItem.append($message)
                .append($name)
                .append($time);
            $(this.options.messageList).append($messageItem);
        },

        clearMessageList: function () {
            $(this.options.messageList).empty();
        }
    });

    return $.stanislavzChat.chatModal;
});
