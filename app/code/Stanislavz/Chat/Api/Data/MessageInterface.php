<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Api\Data;

use Magento\Tests\NamingConvention\true\string;

interface MessageInterface
{
    /**
     * @return int|string|null
     */
    public function getId();

    /**
     * @param int|string $messageId
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setId($messageId): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return int|string|null
     */
    public function getMessageId();

    /**
     * @param int|string $messageId
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setMessageId($messageId): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return string|null
     */
    public function getAuthorType(): ?string;

    /**
     * @param string $authorType
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setAuthorType($authorType): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return int|string|null
     */
    public function getAuthorId();

    /**
     * @param int|string $authorId
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setAuthorId($authorId): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return string|null
     */
    public function getAuthorName(): ?string;

    /**
     * @param string $authorName
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setAuthorName($authorName): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * @param string $message
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setMessage($message): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return int|string|null
     */
    public function getWebsiteId();

    /**
     * @param int|string $websiteId
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setWebsiteId($websiteId): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return string|null
     */
    public function getChatHash(): ?string;

    /**
     * @param string $chatHash
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setChatHash($chatHash): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     */
    public function setCreatedAt($createdAt): \Stanislavz\Chat\Api\Data\MessageInterface;
}
