<?php
declare(strict_types=1);

namespace Omv\RDStation\Plugin\Authentication;

use Omv\RDStation\Model\Cache\Token as TokenCache;
use Omv\RDStation\Spi\Data\TokenResponseInterface;
use Omv\RDStation\Spi\Service\Authentication;

class GetTokenFromCache
{
    /**
     * @var TokenCache
     */
    private $tokenCache;

    /**
     * GetTokenForCache constructor.
     * @param TokenCache $tokenCache
     */
    public function __construct(TokenCache $tokenCache)
    {
        $this->tokenCache = $tokenCache;
    }

    /**
     * @param Authentication $subject
     * @param callable $proceed
     * @return TokenResponseInterface
     */
    public function aroundGetAuthenticationToken(Authentication $subject, callable $proceed): TokenResponseInterface
    {
        if ($this->tokenCache->test(TokenCache::TYPE_IDENTIFIER)) {
            return $this->tokenCache->load(TokenCache::TYPE_IDENTIFIER);
        }

        return $proceed();
    }

    /**
     * @param Authentication $subject
     * @param TokenResponseInterface $result
     * @return TokenResponseInterface
     */
    public function afterGetAuthenticationToken(
        Authentication $subject,
        TokenResponseInterface $result
    ): TokenResponseInterface {
        if (!$this->tokenCache->test(TokenCache::TYPE_IDENTIFIER)) {
            $this->tokenCache->save($result, TokenCache::TYPE_IDENTIFIER);
        }

        return $result;
    }
}
