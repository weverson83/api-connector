<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

use Magento\Framework\DataObject;

class TokenResponse extends DataObject implements TokenResponseInterface
{

    /**
     * @param string $accessToken
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setAccessToken(string $accessToken): TokenResponseInterface
    {
        return $this->setData(self::ACCESS_TOKEN, $accessToken);
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->getData(self::ACCESS_TOKEN);
    }

    /**
     * @param string $refreshToken
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setRefreshToken(string $refreshToken): TokenResponseInterface
    {
        return $this->setData(self::REFRESH_TOKEN, $refreshToken);
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->getData(self::REFRESH_TOKEN);
    }

    /**
     * @param int $expiresIn
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setExpiresIn(int $expiresIn): TokenResponseInterface
    {
        return $this->setData(self::EXPIRES_IN, $expiresIn);
    }

    /**
     * @return int|null
     */
    public function getExpiresIn(): ?int
    {
        return $this->getData(self::EXPIRES_IN);
    }
}
