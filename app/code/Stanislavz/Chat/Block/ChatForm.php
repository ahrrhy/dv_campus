<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Block;

use Stanislavz\Chat\Model\ResourceModel\Message\Collection;
use Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory;

/**
 * Class ChatForm
 * Provides chat form
 */
class ChatForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CollectionFactory
     */
    private $chatCollectionFactory;

    public function __construct(
        \Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory $chatCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
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
     * @param string $chatHash
     * @return Collection
     */
    public function getLastMessages(string $chatHash)
    {
        /** @var Collection $chatCollection */
        $chatCollection = $this->chatCollectionFactory->create();
        return $chatCollection->addFieldToFilter('chat_hash', $chatHash)
            ->setOrder('created_at', $chatCollection::SORT_ORDER_DESC)
            ->setPageSize(10);
    }
}
