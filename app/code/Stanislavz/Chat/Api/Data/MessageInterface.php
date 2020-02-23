<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Api\Data;

interface MessageInterface
{
    /**
     * @return int|string|null
     */
    public function getMessageId();

    /**
     * @param int|string $messageId
     * @return $this
     */
    public function setMessageId($messageId): self;

    /**
     * @return int|string|null
     */
    public function getMessageId();

    /**
     * @param int|string $messageId
     * @return $this
     */
    public function setMessageId($messageId): self;
}
