define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('stanislavzChat.chatButtonInit', {
        options: {
            hideButton: true
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.stanislavz_Chat', $.proxy(this.openChat, this));
            $(this.element).on('stanislavz_Chat_closeChat.stanislavz_Chat', $.proxy(this.closeChat, this));
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
            $(document).trigger('stanislavz_Chat_openChat');
            if (this.options.hideButton) {
                $(this.element).addClass('hidden');
            }
        },

        /**
         * Close Chat Form
         */
        closeChat: function () {
            if (this.options.hideButton) {
                $(this.element).removeClass('hidden');
            }
        }
    });

    return $.stanislavzChat.chatButtonInit;
});