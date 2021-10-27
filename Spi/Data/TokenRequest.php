<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

use Magento\Framework\DataObject;

class TokenRequest extends DataObject implements TokenRequestInterface
{
    const ENDPOINT = 'auth/token';

    /**
     * @return string
     */
    public function endpoint(): string
    {
        return self::ENDPOINT;
    }

    /**
     * @return string
     */
    public function responseType(): string
    {
        return TokenResponseInterface::class;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getData(self::CLIENT_ID);
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->getData(self::CLIENT_SECRET);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->getData(self::CODE);
    }

    /**
     * @param string $clientId
     * @return TokenRequestInterface
     */
    public function setClientId(string $clientId): TokenRequestInterface
    {
        return $this->setData(self::CLIENT_ID, $clientId);
    }

    /**
     * @param string $clientSecret
     * @return TokenRequestInterface
     */
    public function setClientSecret(string $clientSecret): TokenRequestInterface
    {
        return $this->setData(self::CLIENT_SECRET, $clientSecret);
    }

    /**
     * @param string $code
     * @return TokenRequestInterface
     */
    public function setCode(string $code): TokenRequestInterface
    {
        return $this->setData(self::CODE, $code);
    }
}
