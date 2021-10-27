<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;


interface TokenRequestInterface extends RequestInterface
{
    const CLIENT_ID = 'client_id';
    const CLIENT_SECRET = 'client_secret';
    const CODE = 'code';

    /**
     * @return string
     */
    public function getClientId(): string;

    /**
     * @param string $clientId
     * @return \Omv\RDStation\Spi\Data\TokenRequestInterface
     */
    public function setClientId(string $clientId): self;

    /**
     * @return string
     */
    public function getClientSecret(): string;

    /**
     * @param string $clientSecret
     * @return \Omv\RDStation\Spi\Data\TokenRequestInterface
     */
    public function setClientSecret(string $clientSecret): self;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @param string $code
     * @return \Omv\RDStation\Spi\Data\TokenRequestInterface
     */
    public function setCode(string $code): self;
}
