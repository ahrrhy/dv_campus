<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Observer\Visitor;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Stanislavz\Chat\Model\ChatHashModel;
use Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory;
use Psr\Log\LoggerInterface;

class BindCustomerLoginObserver  implements ObserverInterface
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Stanislavz\Chat\Model\ChatHashModel $chatHashModel,
        \Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory $chatCollectionFactory
    ) {
        $this->logger = $logger;
        $this->transactionFactory = $transactionFactory;
        $this->chatHashModel = $chatHashModel;
        $this->chatCollectionFactory = $chatCollectionFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Data\Customer $customer */
        $customer = $observer->getData('customer');
        $this->updateChatMessages($customer);
    }

    /**
     * @param \Magento\Customer\Model\Data\Customer $customer
     */
    private function updateChatMessages($customer)
    {
        /** @var \Stanislavz\Chat\Model\ResourceModel\Message\Collection $chatCollection */
        $chatCollection = $this->chatCollectionFactory->create();
        /** @var \Magento\Framework\DB\Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $chatCollection->addFieldToFilter('chat_hash', $this->chatHashModel->getChatHashCookie());
        /** @var \Stanislavz\Chat\Model\Message $message */
        foreach ($chatCollection as $message) {
            $message->setAuthorId((int)$customer->getId())
                ->setAuthorName(
                    $customer->getFirstname() . ' ' . $customer->getLastname()
                );
            $transaction->addObject($message);
        }
        try {
            $transaction->save();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
