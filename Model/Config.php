<?php
declare(strict_types=1);

namespace Omv\RDStation\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Omv\RDStation\Spi\Exception\UnexpectedValueException;

class Config
{
    const CFG_OAUTH_CODE = 'omv_rdstation/connection/oauth_code';
    const CFG_CLIENT_ID = 'omv_rdstation/connection/client_id';
    const CFG_CLIENT_SECRET = 'omv_rdstation/connection/client_secret';
    const CFG_PUBLIC_TOKEN = 'omv_rdstation/connection/public_token';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
    }

    public function getOAuthCode(): string
    {
        $code = $this->scopeConfig->getValue(
            static::CFG_OAUTH_CODE,
            ScopeInterface::SCOPE_STORE
        );

        if (empty($code)) {
            throw new UnexpectedValueException('OAuth token is not set. Please authenticate with RDStation.');
        }

        return $code;
    }

    public function getClientId(): string
    {
        return $this->scopeConfig->getValue(
            static::CFG_CLIENT_ID,
            ScopeInterface::SCOPE_STORE
        ) ?? '';
    }

    public function getClientSecret(): string
    {
        return $this->scopeConfig->getValue(
                static::CFG_CLIENT_SECRET,
                ScopeInterface::SCOPE_STORE
            ) ?? '';
    }

    public function getPublicToken(): string
    {
        return $this->scopeConfig->getValue(
                static::CFG_PUBLIC_TOKEN,
                ScopeInterface::SCOPE_STORE
            ) ?? '';
    }
}
