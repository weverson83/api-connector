<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

interface TokenResponseInterface extends ResponseInterface
{
    const ACCESS_TOKEN = 'access_token';
    const REFRESH_TOKEN = 'refresh_token';
    const EXPIRES_IN = 'expires_in';

    /**
     * @param string $accessToken
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setAccessToken(string $accessToken): self;

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * @param string $refreshToken
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setRefreshToken(string $refreshToken): self;

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string;

    /**
     * @param int $expiresIn
     * @return \Omv\RDStation\Spi\Data\TokenResponseInterface
     */
    public function setExpiresIn(int $expiresIn): self;

    /**
     * @return int|null
     */
    public function getExpiresIn(): ?int;
}
