<?php
declare(strict_types=1);

namespace Omv\RDStation\Api\Data;

interface EventPayloadInterface
{
    /**
     * String constants for property names
     */
    const NAME = "name";
    const EMAIL = "email";
    const CF_CART_ID = "cf_cart_id";
    const CF_CART_TOTAL_ITEMS = "cf_cart_total_items";
    const CF_CART_STATUS = "cf_cart_status";

    /**
     * Getter for Name.
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string $name
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setName(string $name): self;

    /**
     * Getter for Email.
     *
     * @return string
     */
    public function getEmail(): ?string;

    /**
     * Setter for Email.
     *
     * @param string $email
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setEmail(string $email): self;

    /**
     * Getter for CfCartId.
     *
     * @return string
     */
    public function getCfCartId(): ?string;

    /**
     * Setter for CfCartId.
     *
     * @param string $cfCartId
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartId(string $cfCartId): self;

    /**
     * Getter for CfCartTotalItems.
     *
     * @return int
     */
    public function getCfCartTotalItems(): ?int;

    /**
     * Setter for CfCartTotalItems.
     *
     * @param int $cfCartTotalItems
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartTotalItems(int $cfCartTotalItems): self;

    /**
     * Getter for CfCartStatus.
     *
     * @return string
     */
    public function getCfCartStatus(): ?string;

    /**
     * Setter for CfCartStatus.
     *
     * @param string $cfCartStatus
     *
     * @return \Omv\RDStation\Api\Data\EventPayloadInterface
     */
    public function setCfCartStatus(string $cfCartStatus): self;
}
