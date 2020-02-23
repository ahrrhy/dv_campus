<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Model\ResourceModel\Message;

/**
 * Class Collection
 * @package Stanislavz\Chat\Model\ResourceModel\Message
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'message_id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'stanislavz_chat_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'chat_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Stanislavz\Chat\Model\Message',
            'Stanislavz\Chat\Model\ResourceModel\Message'
        );
    }
}
