<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Controller\Chat;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonResult;

    /**
     * Index constructor.
     * @param JsonFactory $jsonResult
     * @param Context $context
     */
    public function __construct(
        JsonFactory $jsonResult,
        Context $context
    ) {
        parent::__construct($context);
        $this->jsonResult = $jsonResult;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->jsonResult->create();
        $requestParams = $this->validateRequest();

        return $result;
    }

    /**
     * @return array
     */
    private function validateRequest(): array
    {
        $request = $this->getRequest()->getParams();
        return $request;
    }
}
