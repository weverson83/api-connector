<?php
declare(strict_types=1);

namespace Omv\RDStation\Model\Data;

use Magento\Framework\DataObject;
use Omv\RDStation\Api\Data\EventInterface;
use Omv\RDStation\Api\Data\EventPayloadInterface;
use Omv\RDStation\Api\Data\EventResponseInterface;
use Omv\RDStation\Spi\Data\RequestInterface;

class Event extends DataObject implements EventInterface, RequestInterface
{
    /**
     * @return string
     */
    public function getEventType(): ?string
    {
        return $this->getData(self::EVENT_TYPE);
    }

    /**
     * @param string $eventType
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setEventType(?string $eventType): EventInterface
    {
        return $this->setData(self::EVENT_TYPE, $eventType);
    }

    /**
     * @return string
     */
    public function getEventFamily(): ?string
    {
        return $this->getData(self::EVENT_FAMILY);
    }

    /**
     * @param string $eventFamily
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setEventFamily(?string $eventFamily): EventInterface
    {
        return $this->setData(self::EVENT_FAMILY, $eventFamily);
    }

    /**
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function getPayload(): ?\Omv\RDStation\Api\Data\EventPayloadInterface
    {
        return $this->getData(self::PAYLOAD);
    }

    /**
     * @param \Omv\RDStation\Model\Data\EventPayload $payload
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setPayload(EventPayloadInterface $payload): EventInterface
    {
        return $this->setData(self::PAYLOAD, $payload);
    }

    /**
     * @return string
     */
    public function endpoint(): string
    {
        return 'platform/events';
    }

    /**
     * @return string
     */
    public function responseType(): string
    {
        return EventResponseInterface::class;
    }
}
