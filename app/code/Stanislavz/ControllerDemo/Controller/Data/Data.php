<?php
declare(strict_types=1);

namespace Stanislavz\ControllerDemo\Controller\Data;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Data
 * @package Stanislavz\ControllerDemo\Controller\Data
 */
class Data extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Data constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }


    public function execute()
    {
        $this->getRequest()->getParams();
        return $this->resultPageFactory->create();
    }
}