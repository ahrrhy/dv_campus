<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Stanislavz\Chat\Model\ResourceModel\Message as MessageResourceModel;
use Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Stanislavz\Chat\Model\MessageFactory as MessageModelFactory;
use Stanislavz\Chat\Model\Message as MessageModel;
use Stanislavz\Chat\Api\Data\MessageInterface;
use Stanislavz\Chat\Api\Data\MessageInterfaceFactory;
use Stanislavz\Chat\Api\Data\MessageSearchResultInterfaceFactory;
use Stanislavz\Chat\Api\MessageRepositoryInterface;

/**
 * Class MessageRepository
 * @package Stanislavz\Chat\Model
 * @SuppressWarnings(PHPMD.LongVariableNames)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageResourceModel
     */
    protected $resource;

    /**
     * @var MessageModelFactory
     */
    protected $messageModelFactory;

    /**
     * @var MessageCollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * @var MessageInterfaceFactory
     */
    protected $messageInterfaceFactory;

    /**
     * @var MessageSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * MessageRepository constructor.
     * @param MessageSearchResultInterfaceFactory $searchResultsFactory
     * @param MessageFactory $messageModelFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param MessageInterfaceFactory $messageInterfaceFactory
     * @param MessageResourceModel $resource
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        MessageSearchResultInterfaceFactory $searchResultsFactory,
        MessageModelFactory $messageModelFactory,
        MessageCollectionFactory $messageCollectionFactory,
        MessageInterfaceFactory $messageInterfaceFactory,
        MessageResourceModel $resource,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->messageInterfaceFactory = $messageInterfaceFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->messageModelFactory   = $messageModelFactory;
        $this->dataObjectHelper     = $dataObjectHelper;
        $this->dataObjectProcessor  = $dataObjectProcessor;
    }

    /**
     * @param MessageInterface $messageModel
     * @return MessageInterface
     * @throws CouldNotSaveException
     */
    public function save(MessageInterface $messageModel): MessageInterface
    {
        try {
            $this->resource->save($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $messageModel;
    }

    /**
     * @param int|string $messageId
     * @return MessageInterface
     * @throws NoSuchEntityException
     */
    public function getById($messageId): MessageInterface
    {
        /** @var MessageModel $messageModel */
        $messageModel = $this->messageModelFactory->create();
        $this->resource->load($messageModel, $messageId);
        if (!$messageModel->getId()) {
            throw new NoSuchEntityException(__('Message with id "%1" does not exist.', $messageId));
        }

        return $messageModel;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Stanislavz\Chat\Api\Data\MessageSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria):
    \Stanislavz\Chat\Api\Data\MessageSearchResultInterface
    {
        /** @var \Stanislavz\Chat\Api\Data\MessageSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Stanislavz\Chat\Model\ResourceModel\Message\Collection $collection */
        $collection = $this->messageCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() === SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $messages = [];
        /** @var MessageModel $messageModel */
        foreach ($collection as $messageModel) {
            /** @var MessageInterface $messageModelInterface */
            $messageModelInterface = $this->messageInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $messageModelInterface,
                $messageModel->getData(),
                'Stanislavz\Chat\Api\Data\MessageInterface'
            );
            $messages[] = $this->dataObjectProcessor->buildOutputDataArray(
                $messageModelInterface,
                'Stanislavz\Chat\Api\Data\MessageInterface'
            );
        }
        $searchResults->setItems($messages);

        return $searchResults;
    }

    /**
     * @param MessageInterface $messageModel
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(MessageInterface $messageModel): bool
    {
        try {
            $this->resource->delete($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $messageId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($messageId): bool
    {
        return $this->delete($this->getById($messageId));
    }
}
