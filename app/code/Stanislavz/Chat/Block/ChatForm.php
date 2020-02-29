<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Block;

/**
 * Class ChatForm
 * Provides chat form
 */
class ChatForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getFormAction(): string
    {
        return $this->getUrl('chat/chat/index');
    }

    public function getLastMessages($chatHashId)
    {

    }
}
