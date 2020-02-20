<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Controller\Chat;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonResult;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * Index constructor.
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param JsonFactory $jsonResult
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        JsonFactory $jsonResult,
        Context $context
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
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
            $requestParams = $this->setSenderName($requestParams);
            $requestParams = $this->setSenderRole($requestParams);
            $requestParams = $this->setCurrentTime($requestParams);
            $data = [
                'status' => 'success',
                'message' => $requestParams
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => 'error',
                'message' => $e->getMessage()
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
        $requestParams['name'] = 'someName';
        return $requestParams;
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setSenderRole(array $requestParams): array
    {
        $requestParams['role'] = 'customer';
        return $requestParams;
    }

    /**
     * @param array $requestParams
     * @return array
     */
    private function setCurrentTime(array $requestParams): array
    {
        $requestParams['time'] = $this->date->gmtDate();
        return $requestParams;
    }
}
