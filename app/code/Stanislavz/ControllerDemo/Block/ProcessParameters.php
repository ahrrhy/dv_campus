<?php
declare(strict_types=1);

namespace Stanislavz\ControllerDemo\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class ProcessParameters
 * @package Stanislavz\ControllerDemo\Block
 */
class ProcessParameters extends \Magento\Framework\View\Element\Template
{
    /**
     * @var array
     */
    private $requestParams;

    /**
     * ProcessParameters constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->requestParams = $this->getRequest()->getParams();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return ($this->requestParams['firstName'] . ' ' . $this->requestParams['lastName'])
            ?: 'Here should be some name';
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->requestParams['githubRepository'] ?: 'Here should be some link';
    }
}
