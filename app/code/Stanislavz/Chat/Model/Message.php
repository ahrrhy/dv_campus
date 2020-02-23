<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Model;

use Stanislavz\Chat\Api\Data\MessageInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Message extends \Magento\Framework\Model\AbstractModel implements MessageInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Stanislavz\Chat\Model\ResourceModel\Message::class);
    }

    /**
     * @return int|string|null
     */
    public function getId()
    {
        return $this->getData('message_id');
    }

    /**
     * @param int|string $messageId
     * @return MessageInterface
     */
    public function setId($messageId): MessageInterface
    {
        return $this->setData('message_id', $messageId);
    }

    /**
     * @return int|string|null
     */
    public function getMessageId()
    {
        return $this->getData('message_id');
    }

    /**
     * @param int|string $messageId
     * @return MessageInterface
     */
    public function setMessageId($messageId): MessageInterface
    {
        return $this->getData('message_id');
    }

    /**
     * @return int|string|null
     */
    public function getAuthorId()
    {
        return $this->getData('author_id');
    }

    /**
     * @param int|string $authorId
     * @return MessageInterface
     */
    public function setAuthorId($authorId): MessageInterface
    {
        return $this->setData('author_id', $authorId);
    }

    /**
     * @return string|null
     */
    public function getAuthorType(): ?string
    {
        return $this->getData('author_type');
    }

    /**
     * @param string $authorType
     * @return MessageInterface
     */
    public function setAuthorType($authorType): MessageInterface
    {
        return $this->setData('author_type', $authorType);
    }

    /**
     * @return string|null
     */
    public function getAuthorName(): ?string
    {
        return $this->getData('author_name');
    }

    /**
     * @param string $authorName
     * @return MessageInterface
     */
    public function setAuthorName($authorName): MessageInterface
    {
        return $this->setData('author_name', $authorName);
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->getData('author_name');
    }

    /**
     * @param string $message
     * @return MessageInterface
     */
    public function setMessage($message): MessageInterface
    {
        return $this->setData('message', $message);
    }

    /**
     * @return int|string|null
     */
    public function getWebsiteId()
    {
        return $this->getData('website_id');
    }

    /**
     * @param int|string $websiteId
     * @return MessageInterface
     */
    public function setWebsiteId($websiteId): MessageInterface
    {
        return $this->setData('website_id', $websiteId);
    }

    /**
     * @return string|null
     */
    public function getChatHash(): ?string
    {
        return $this->getData('chat_hash');
    }

    /**
     * @param string $chatHash
     * @return MessageInterface
     */
    public function setChatHash($chatHash): MessageInterface
    {
        return $this->setData('chat_hash', $chatHash);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData('created_at');
    }

    /**
     * @param string $createdAt
     * @return MessageInterface
     */
    public function setCreatedAt($createdAt): MessageInterface
    {
        return $this->setData('created_at', $createdAt);
    }
}
