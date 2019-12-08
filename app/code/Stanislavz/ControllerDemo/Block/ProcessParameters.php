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
     * ProcessParameters constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return ($this->_request->getParam('firstName') . ' ' . $this->_request->getParam('lastName'))
            ?: 'Here should be some name';
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->_request->getParam('githubRepository') ?: 'Here should be some link';
    }
}
