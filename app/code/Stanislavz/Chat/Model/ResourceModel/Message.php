<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Model\ResourceModel;

/**
 * Class Message
 * @package Stanislavz\Chat\Model\ResourceModel
 */
class Message extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('stanislavz_chat', 'message_id');
    }
}
