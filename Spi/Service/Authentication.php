<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Service;

use Omv\RDStation\Model\Config;
use Omv\RDStation\Spi\Data\TokenRequest;
use Omv\RDStation\Spi\Data\TokenResponseInterface;

class Authentication
{
    /**
     * @var RequestProcessor
     */
    private $requestProcessor;
    /**
     * @var TokenRequest
     */
    private $token;

    /**
     * Connection constructor.
     * @param Config $config
     */
    public function __construct(
        RequestProcessor $requestProcessor,
        TokenRequest $oauthTokenRequest
    ) {
        $this->requestProcessor = $requestProcessor;
        $this->token = $oauthTokenRequest;
    }

    /**
     * @return TokenResponseInterface
     */
    public function getAuthenticationToken(): TokenResponseInterface
    {
        return $this->authenticate();
    }

    /**
     * @retrun TokenInterface
     */
    private function authenticate(): TokenResponseInterface
    {
        return $this->requestProcessor->process($this->token);
    }
}
