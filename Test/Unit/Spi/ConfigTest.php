<?php
declare(strict_types=1);

namespace Omv\RDStation\Test\Unit\Spi;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Omv\RDStation\Model\Config;
use Omv\RDStation\Spi\Exception\UnexpectedValueException;
use PHPUnit\Framework\MockObject\MockObject;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ScopeConfigInterface|MockObject
     */
    private $scopeConfig;
    /**
     * @var Config|MockObject
     */
    private $model;

    protected function setUp()
    {
        $objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $className = Config::class;
        $arguments = $objectManagerHelper->getConstructArguments($className);

        $this->scopeConfig = $arguments['scopeConfig'];

        $this->model = $objectManagerHelper->getObject($className, $arguments);
    }

    public function testGetOAuthCode(): void
    {
        $this->scopeConfig->method('getValue')
            ->with(
                Config::CFG_OAUTH_CODE,
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('CODE');

        $this->assertEquals(
            'CODE',
            $this->model->getOAuthCode()
        );
    }

    public function testEmptyOAuthCodeThrowsException(): void
    {
        $this->scopeConfig->method('getValue')
            ->with(
                Config::CFG_OAUTH_CODE,
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(null);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('OAuth token is not set. Please authenticate with RDStation.');

        $this->model->getOAuthCode();
    }

    public function testGetClientId(): void
    {
        $this->scopeConfig->method('getValue')
            ->with(
                Config::CFG_CLIENT_ID,
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('CLIENT_ID');

        $this->assertEquals('CLIENT_ID', $this->model->getClientId());
    }

    public function testGetClientSecret(): void
    {
        $this->scopeConfig->method('getValue')
            ->with(
                Config::CFG_CLIENT_SECRET,
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('CLIENT_SECRET');

        $this->assertEquals('CLIENT_SECRET', $this->model->getClientSecret());
    }

    public function testGetPublicToken(): void
    {
        $this->scopeConfig->method('getValue')
            ->with(
                Config::CFG_PUBLIC_TOKEN,
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('PUBLIC_TOKEN');

        $this->assertEquals('PUBLIC_TOKEN', $this->model->getPublicToken());
    }
}
