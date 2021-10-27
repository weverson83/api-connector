<?php
declare(strict_types=1);

namespace Omv\RDStation\Api\Data;

interface EventInterface
{
    /**
     * String constants for property names
     */
    const EVENT_TYPE = "event_type";
    const EVENT_FAMILY = "event_family";
    const PAYLOAD = "payload";

    /**
     * Getter for EventType.
     *
     * @return string
     */
    public function getEventType(): ?string;

    /**
     * Setter for EventType.
     *
     * @param string $eventType
     *
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setEventType(?string $eventType): self;

    /**
     * Getter for EventFamily.
     *
     * @return string
     */
    public function getEventFamily(): ?string;

    /**
     * Setter for EventFamily.
     *
     * @param string|null $eventFamily
     *
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setEventFamily(?string $eventFamily): self;

    /**
     * Getter for Payload.
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function getPayload(): ?\Omv\RDStation\Api\Data\EventPayloadInterface;

    /**
     * Setter for Payload.
     *
     * @param \Omv\RDStation\Api\Data\EventPayloadInterface $payload
     *
     * @return \Omv\RDStation\Api\Data\EventInterface
     */
    public function setPayload(EventPayloadInterface $payload): self;
}
