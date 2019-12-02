<?php
declare(strict_types=1);

namespace Stanislavz\ControllerDemo\Controller\Redirect;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;

/**
 * Class Forward
 * @package Stanislavz\ControllerDemo\Controller\Redirect
 */
class Forward extends \Magento\Framework\App\Action\Action
{
    /** @var array */
    private const DATA = [
        'firstName' => 'Stanislav',
        'lastName' => 'Zhuravel',
        'githubRepository' => 'https://github.com/ahrrhy/dv_campus'
    ];
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * Forward constructor.
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getData();
        /** @var \Magento\Framework\Controller\Result\Forward $result */
        $result = $this->resultForwardFactory->create();
        $result->setParams($data);
        $result->setController('data');
        $result->forward('data');
        return $result;
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return self::DATA;
    }
}
