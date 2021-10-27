<?php
declare(strict_types=1);

namespace Omv\RDStation\Model\Data;

use Magento\Framework\DataObject;
use Omv\RDStation\Api\Data\EventResponseInterface;

class EventResponse extends DataObject implements EventResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getEventUuid(): ?string
    {
        return $this->getData(self::EVENT_UUID);
    }

    /**
     * @inheritDoc
     */
    public function setEventUuid(?string $eventUuid): void
    {
        $this->setData(self::EVENT_UUID, $eventUuid);
    }
}
