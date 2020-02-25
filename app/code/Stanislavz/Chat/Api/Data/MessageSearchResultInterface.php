<?php

namespace Stanislavz\Chat\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface MessageSearchResultInterface
 * @package Stanislavz\Chat\Api\Data\
 * @api
 */
interface MessageSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get request products list.
     *
     * @return \Stanislavz\Chat\Api\Data\MessageInterface[]
     */
    public function getItems(): array;

    /**
     * Set request samples list.
     *
     * @param \Stanislavz\Chat\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}
