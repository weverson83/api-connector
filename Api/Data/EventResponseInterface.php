<?php
declare(strict_types=1);

namespace Omv\RDStation\Api\Data;

use Omv\RDStation\Spi\Data\ResponseInterface;

interface EventResponseInterface extends ResponseInterface
{
    /**
     * String constants for property names
     */
    const EVENT_UUID = "event_uuid";

    /**
     * Getter for EventUuid.
     *
     * @return string|null
     */
    public function getEventUuid(): ?string;

    /**
     * Setter for EventUuid.
     *
     * @param string|null $eventUuid
     *
     * @return void
     */
    public function setEventUuid(?string $eventUuid): void;
}
