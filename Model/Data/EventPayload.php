<?php
declare(strict_types=1);

namespace Omv\RDStation\Model\Data;

use Magento\Framework\DataObject;
use Omv\RDStation\Api\Data\EventPayloadInterface;

class EventPayload extends DataObject implements EventPayloadInterface
{
    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setName(string $name): EventPayloadInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param string $email
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setEmail(string $email): EventPayloadInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string
     */
    public function getCfCartId(): ?string
    {
        return $this->getData(self::CF_CART_ID);
    }

    /**
     * @param string $cfCartId
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartId(string $cfCartId): EventPayloadInterface
    {
        return $this->setData(self::CF_CART_ID, $cfCartId);
    }

    /**
     * @return int
     */
    public function getCfCartTotalItems(): ?int
    {
        return $this->getData(self::CF_CART_TOTAL_ITEMS);
    }

    /**
     * @param int $cfCartTotalItems
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartTotalItems(int $cfCartTotalItems): EventPayloadInterface
    {
        return $this->setData(self::CF_CART_TOTAL_ITEMS, $cfCartTotalItems);
    }

    /**
     * @return string
     */
    public function getCfCartStatus(): ?string
    {
        return $this->getData(self::CF_CART_STATUS);
    }

    /**
     * @param string $cfCartStatus
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartStatus(string $cfCartStatus): EventPayloadInterface
    {
        return $this->setData(self::CF_CART_STATUS, $cfCartStatus);
    }
}
