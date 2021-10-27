<?php
declare(strict_types=1);

namespace Omv\RDStation\Model\Cache;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;

class Token extends TagScope
{
    const TYPE_IDENTIFIER = 'rdstation_token';
    const CACHE_TAG = 'RDTOKEN';

    /**
     * @param FrontendPool $cacheFrontendPool
     */
    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct($cacheFrontendPool->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);
    }

    public function load($identifier)
    {
        $tokenString = parent::load($identifier);
        return unserialize($tokenString);
    }

    public function save($data, $identifier, array $tags = [], $lifeTime = null)
    {
        $data = serialize($data);
        return parent::save($data, $identifier, $tags, $lifeTime);
    }
}
