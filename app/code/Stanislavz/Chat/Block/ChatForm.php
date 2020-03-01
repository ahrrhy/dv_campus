<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Block;

use Stanislavz\Chat\Model\ChatHashModel;
use Stanislavz\Chat\Model\ResourceModel\Message\Collection;
use Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory;

/**
 * Class ChatForm
 * Provides chat form
 */
class ChatForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ChatHashModel
     */
    private $chatHashModel;

    /**
     * @var CollectionFactory
     */
    private $chatCollectionFactory;

    /**
     * ChatForm constructor.
     * @param ChatHashModel $chatHashModel
     * @param CollectionFactory $chatCollectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Stanislavz\Chat\Model\ChatHashModel $chatHashModel,
        \Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory $chatCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->chatHashModel = $chatHashModel;
        $this->chatCollectionFactory = $chatCollectionFactory;
    }

    /**
     * @return string
     */
    public function getFormAction(): string
    {
        return $this->getUrl('chat/chat/index');
    }

    /**
     * @return string|null
     */
    public function getChatHashCookie(): ?string
    {
        return $this->chatHashModel->getChatHashCookie();
    }
    /**
     * @return Collection
     */
    public function getLastMessages()
    {
        /** @var Collection $chatCollection */
        $chatCollection = $this->chatCollectionFactory->create();
        $chatCollection->setOrder('created_at', $chatCollection::SORT_ORDER_DESC)
            ->setPageSize(10);
        if ($this->chatHashModel->getCustomerId()) {
            $chatCollection->addFieldToFilter('author_id', $this->chatHashModel->getCustomerId());
        } else {
            $chatCollection->addFieldToFilter('chat_hash', $this->chatHashModel->getChatHashCookie());
        }

        return $chatCollection;
    }

    /**
     * Setting chatHashCookie
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    private function setChatHashCookie(): void
    {
        $chatHashCookie = $this->chatHashModel->getChatHashCookie();
        if ($chatHashCookie === 'default value') {
            $this->chatHashModel->setChatHash($this->chatHashModel->generateChatHash());
        }
    }

    protected function _beforeToHtml()
    {
        $this->setChatHashCookie();
        return parent::_beforeToHtml();
    }
}
