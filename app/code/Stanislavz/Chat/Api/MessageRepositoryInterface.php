<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Stanislavz\Chat\Api\Data\MessageInterface;

/**
 * Interface MessageRepositoryInterface
 * @package Stanislavz\Chat\Api
 * @api
 */
interface MessageRepositoryInterface
{
    /**
     * Save message.
     *
     * @param \Stanislavz\Chat\Api\Data\MessageInterface $messageInterface
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     * @throws CouldNotSaveException
     */
    public function save(MessageInterface $messageInterface): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * Retrieve message.
     *
     * @param int|string $messageId
     * @return \Stanislavz\Chat\Api\Data\MessageInterface
     * @throws LocalizedException
     */
    public function getById($messageId): \Stanislavz\Chat\Api\Data\MessageInterface;

    /**
     * Retrieve message matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Stanislavz\Chat\Api\Data\MessageSearchResultInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria):
    \Stanislavz\Chat\Api\Data\MessageSearchResultInterface;

    /**
     * Delete message.
     *
     * @param \Stanislavz\Chat\Api\Data\MessageInterface $messageInterface
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(MessageInterface $messageInterface): bool;

    /**
     * Delete message by ID.
     *
     * @param int $messageId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($messageId): bool;
}
