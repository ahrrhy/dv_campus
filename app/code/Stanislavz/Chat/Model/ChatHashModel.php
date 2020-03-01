<?php

declare(strict_types=1);

namespace Stanislavz\Chat\Model;

use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;

class ChatHashModel
{
    /**
     * Chat hash
     */
    const CHAT_HASH = 'chat_hash';

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    private $cookieManager;

    private $cookieMetadataFactory;

    /**
     * @var \Magento\Framework\Math\Random
     */
    private $mathRandom;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(
        \Magento\Framework\Stdlib\Cookie\PublicCookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Math\Random $mathRandom,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->mathRandom = $mathRandom;
        $this->customerSession = $customerSession;
    }

    public function generateChatHash(): string
    {
        return $this->mathRandom->getRandomString(16);
    }

    /**
     * @param string $chatHash
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    public function setChatHash(string $chatHash)
    {
        /** @var PublicCookieMetadata $meta */
        $meta = $this->cookieMetadataFactory->create();
        $meta->setPath($this->customerSession->getCookiePath());
        $meta->setDomain($this->customerSession->getCookieDomain());
        $meta->setDuration($this->customerSession->getCookieLifetime());
        $this->cookieManager->setPublicCookie(self::CHAT_HASH, $chatHash, $meta);
    }

    /**
     * @return string|null
     */
    public function getChatHashCookie(): ?string
    {
        return $this->cookieManager->getCookie(
            self::CHAT_HASH,
            'default value'
        );
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return (int)$this->customerSession->getCustomerId();
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        $name = '';
        $customerData = $this->customerSession->getCustomerData();
        if ($customerData !== null) {
            $name = $customerData->getFirstname() . ' ' . $customerData->getLastname();
        }
        return $name;
    }
}
