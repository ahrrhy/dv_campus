define([
    'jquery',
    'Stanislavz_Chat/js/widget/chat-modal',
    'jquery/ui'
], function ($, stanislavzChatChatModal) {
    'use strict';

    $.widget('stanislavzChat.chatButtonInit', {
        options: {
            chatModal: '#chat-wrapper',
            close: '.chat-close',
            hideButton: true
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.stanislavz_Chat', $.proxy(this.openChat, this));
            $(this.element).on('stanislavz_Chat_closeChat.stanislavz_Chat', $.proxy(this.closeChat, this));
            $(this.options.close).on('click.stanislavz_Chat', $.proxy(this.destroyChatModal, this));
        },

        /**
         * jQuery(jQuery('.chat-initial').get(0)).data('stanislavzChatChatButtonInit').destroy()
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.stanislavz_Chat');
            $(this.element).off('stanislavz_Chat_closeChat.stanislavz_Chat');
        },

        /**
         * Open Chat Form
         */
        openChat: function () {
            $(this.options.chatModal).data('mage-modal').openModal();
            if (this.options.hideButton) {
                $(this.element).parent().addClass('hidden');
            }
        },

        /**
         * Close Chat Form
         */
        closeChat: function () {
            if (this.options.hideButton) {
                $(this.element).parent().removeClass('hidden');
            }
        },

        destroyChatModal: function () {
            $(this.options.chatModal).data('stanislavzChatChatModal').destroy();
            stanislavzChatChatModal({}, $(this.options.chatModal));
        }
    });

    return $.stanislavzChat.chatButtonInit;
});