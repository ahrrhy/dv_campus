<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Controller\Chat;

use Stanislavz\Chat\Model\MessageFactory as MessageFactory;
use Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DB\Transaction;

class Index extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonResult;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var MessageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Index constructor.
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param MessageFactory $messageFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param JsonFactory $jsonResult
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Stanislavz\Chat\Model\MessageFactory $messageFactory,
        \Stanislavz\Chat\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResult,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->messageFactory = $messageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->transactionFactory = $transactionFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->jsonResult = $jsonResult;
        $this->date = $date;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $requestParams = $this->validateRequest();
            // mock the data we don't have yet
            $requestParams = $this->setSenderName($requestParams);
            $requestParams = $this->setSenderRole($requestParams);
            $requestParams = $this->setSenderId($requestParams);
            $requestParams = $this->setChatHash($requestParams);
            $requestParams = $this->setCurrentTime($requestParams);
            // mock the data we don't have yet

            //saving message
            /** @var array $messageData */
            $messageData = $this->saveMessage($requestParams)->getData();
            if (!isset($messageData['message_id'])) {
                throw new LocalizedException;
            }
            $data = [
                'status' => 'success',
                'message' => $messageData
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status' => 'error'
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->jsonResult->create();

        return $result->setData($data);
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    private function validateRequest(): array
    {
        $request = $this->getRequest();
        if (trim($request->getParam('message')) === '') {
            throw new LocalizedException(__('Enter the First Name and try again.'));
        }
        if (trim($request->getParam('hideit')) !== '') {
            throw new \Exception();
        }
        if (!$request->isAjax()) {
            throw new LocalizedException(__('This request is not valid and can not be processed.'));
        }

        return $request->getParams();
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setSenderName(array $requestParams): array
    {
        $requestParams['author_name'] = 'someName';
        return $requestParams;
    }

    private function setSenderId(array $requestParams): array
    {
        $requestParams['author_id'] = 12;
        return $requestParams;
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setSenderRole(array $requestParams): array
    {
        $requestParams['author_type'] = 'customer';
        return $requestParams;
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setChatHash(array $requestParams): array
    {
        $requestParams['chat_hash'] = 'some_chat_hash';
        return $requestParams;
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setCurrentTime(array $requestParams): array
    {
        $requestParams['created_at'] = $this->date->gmtDate();
        return $requestParams;
    }

    /**
     * @param array $messageData
     * @return \Stanislavz\Chat\Model\Message
     */
    private function saveMessage(array $messageData)
    {
        $transaction = $this->transactionFactory->create();
        $messageModel = $this->messageFactory->create();
        try {
            $messageData['website_id'] = (int) $this->storeManager->getWebsite()->getId();
            $messageModel->setData($messageData);
            $transaction->addObject($messageModel);
            $transaction->save();
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager
                ->addErrorMessage(__('Your message can\'t be saved. Please, contact us if you see this message.'));
        }

        return $messageModel;
    }
}
