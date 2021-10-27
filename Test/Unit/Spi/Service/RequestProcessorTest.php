<?php
declare(strict_types=1);

namespace Omv\RDStation\Test\Unit\Spi\Service;

use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\DataObject;
use Magento\Framework\HTTP\ZendClient;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Webapi\ServiceInputProcessor;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use Magento\Framework\Webapi\ServiceTypeToEntityTypeMap;
use Omv\RDStation\Spi\Data\ErrorResponseInterface;
use Omv\RDStation\Spi\Data\TokenRequest;
use Omv\RDStation\Spi\Data\TokenResponse;
use Omv\RDStation\Spi\Service\Authentication;
use Omv\RDStation\Spi\Service\RequestProcessor;
use Omv\RDStation\Spi\Exception\UnauthorizedException;

class RequestProcessorTest extends \PHPUnit\Framework\TestCase
{
    /** @var ServiceInputProcessor */
    private $serviceInputProcessor;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $attributeValueFactoryMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $customAttributeTypeLocator;

    /** @var \PHPUnit_Framework_MockObject_MockObject  */
    private $objectManagerMock;

    /** @var  \Magento\Framework\Reflection\MethodsMap */
    private $methodsMap;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $fieldNamer;

    /**
     * @var ServiceTypeToEntityTypeMap|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serviceTypeToEntityTypeMap;
    /**
     * @var RequestProcessor|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestProcessor;
    /**
     * @var ServiceOutputProcessor
     */
    private $serviceOutputProcessor;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Zend_Http_Response
     */
    private $zendHttpResponse;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->objectManagerMock = $this->getMockBuilder(\Magento\Framework\ObjectManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManagerMock->expects($this->any())
            ->method('create')
            ->willReturnCallback(
                function ($className, $arguments = []) use ($objectManager) {
                    return $objectManager->getObject($className, $arguments);
                }
            );

        /** @var \Magento\Framework\Reflection\TypeProcessor $typeProcessor */
        $typeProcessor = $objectManager->getObject(\Magento\Framework\Reflection\TypeProcessor::class);
        $cache = $this->getMockBuilder(\Magento\Framework\App\Cache\Type\Reflection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $cache->expects($this->any())->method('load')->willReturn(false);

        $this->customAttributeTypeLocator = $this->getMockBuilder(
            \Magento\Eav\Model\TypeLocator::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->attributeValueFactoryMock = $this->getMockBuilder(\Magento\Framework\Api\AttributeValueFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->attributeValueFactoryMock->expects($this->any())
            ->method('create')
            ->willReturnCallback(
                function () use ($objectManager) {
                    return $objectManager->getObject(\Magento\Framework\Api\AttributeValue::class);
                }
            );

        $this->fieldNamer = $this->getMockBuilder(\Magento\Framework\Reflection\FieldNamer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFieldNameForMethodName'])
            ->getMock();

        $this->fieldNamer->method('getFieldNameForMethodName')
            ->willReturnCallback(
                function ($methodName) {
                    if (substr($methodName, 0, 2) === \Magento\Framework\Reflection\FieldNamer::IS_METHOD_PREFIX) {
                        return SimpleDataObjectConverter::camelCaseToSnakeCase(substr($methodName, 2));
                    } elseif (substr($methodName, 0, 3) === \Magento\Framework\Reflection\FieldNamer::HAS_METHOD_PREFIX) {
                        return SimpleDataObjectConverter::camelCaseToSnakeCase(substr($methodName, 3));
                    } elseif (substr($methodName, 0, 3) === \Magento\Framework\Reflection\FieldNamer::GETTER_PREFIX) {
                        return SimpleDataObjectConverter::camelCaseToSnakeCase(substr($methodName, 3));
                    }

                    return null;
                }
            );

        $this->methodsMap = $objectManager->getObject(
            \Magento\Framework\Reflection\MethodsMap::class,
            [
                'cache' => $cache,
                'typeProcessor' => $typeProcessor,
                'attributeTypeResolver' => $this->attributeValueFactoryMock->create(),
                'fieldNamer' => $this->fieldNamer
            ]
        );
        $serializerMock = $this->createMock(SerializerInterface::class);
        $serializerMock->method('serialize')
            ->willReturn('serializedData');
        $serializerMock->method('unserialize')
            ->willReturn('unserializedData');
        $objectManager->setBackwardCompatibleProperty(
            $this->methodsMap,
            'serializer',
            $serializerMock
        );
        $this->serviceTypeToEntityTypeMap = $this->getMockBuilder(ServiceTypeToEntityTypeMap::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceInputProcessor = $objectManager->getObject(
            \Magento\Framework\Webapi\ServiceInputProcessor::class,
            [
                'typeProcessor' => $typeProcessor,
                'objectManager' => $this->objectManagerMock,
                'customAttributeTypeLocator' => $this->customAttributeTypeLocator,
                'attributeValueFactory' => $this->attributeValueFactoryMock,
                'methodsMap' => $this->methodsMap,
                'serviceTypeToEntityTypeMap' => $this->serviceTypeToEntityTypeMap
            ]
        );

        $dataObjectProcessor = $objectManager->getObject(DataObjectProcessor::class, [
            'methodsMapProcessor' => $this->methodsMap,
            'typeCaster' => $objectManager->getObject(\Magento\Framework\Reflection\TypeCaster::class),
            'fieldNamer' => $this->fieldNamer
        ]);

        $this->serviceOutputProcessor = $objectManager->getObject(
            \Magento\Framework\Webapi\ServiceOutputProcessor::class,
            [
                'dataObjectProcessor' => $dataObjectProcessor,
                'typeProcessor' => $typeProcessor,
                'methodsMapProcessor' => $this->methodsMap,
            ]
        );

        /** @var \Magento\Framework\Reflection\NameFinder $nameFinder */
        $nameFinder = $objectManager->getObject(\Magento\Framework\Reflection\NameFinder::class);
        $objectManager->setBackwardCompatibleProperty(
            $this->serviceInputProcessor,
            'nameFinder',
            $nameFinder
        );

        $httpClientFactory = $this->getMockBuilder(\Magento\Framework\HTTP\ZendClientFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $zendClient = $this->getMockBuilder(ZendClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['getBody', 'request'])
            ->getMock();


        $this->zendHttpResponse = $this->getMockBuilder(\Zend_Http_Response::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();

        $zendClient->method('request')
            ->willReturn($this->zendHttpResponse);

        $httpClientFactory->method('create')
            ->willReturn($zendClient);

//        $httpClientFactory->method('create')
//            ->willReturn($objectManager->getObject(ZendClient::class));

        $this->requestProcessor = $objectManager->getObject(RequestProcessor::class, [
            'serviceInputProcessor' => $this->serviceInputProcessor,
            'serviceOutputProcessor' => $this->serviceOutputProcessor,
            'methodsMapProcessor' => $this->methodsMap,
            'httpClientFactory' => $httpClientFactory,
            'json' => $objectManager->getObject(Json::class),
        ]);
    }

    public function testRequestReturnObject()
    {
        $this->zendHttpResponse->method('getBody')
            ->willReturn(
                '{"access_token":"BEARER","expires_in":86400,"refresh_token":"9YORmXHgOI32k"}'
            );

        $this->zendHttpResponse->method('isError')
            ->willReturn(false);

        /** @var TokenRequest $object */
        $object = $this->objectManagerMock->create(TokenRequest::class);
        $object->setClientId('ec5d6559-0176-4586-be91-3bf3ded240a0')
            ->setClientSecret('b0a134c908e3430c917fc837e4421334')
            ->setCode('02dd0383f883d445247c6ee87a573a77');

        /** @var TokenResponse $result */
        $result = $this->requestProcessor->process($object);

        $this->assertInstanceOf(TokenResponse::class, $result);
        $this->assertNotNull($result->getAccessToken());
        $this->assertNotNull($result->getRefreshToken());
        $this->assertNotNull($result->getExpiresIn());
    }

    public function testErrorValidationUnauthorized()
    {
        $this->zendHttpResponse->method('getBody')
            ->willReturn(
                '{"errors":[{"error_type":"ACCESS_DENIED","error_message":"Wrong credentials provided."}]}'
            );

        $this->zendHttpResponse->method('isError')
            ->willReturn(true);

        $this->zendHttpResponse->method('getStatus')
            ->willReturn(401);

        $object = $this->objectManagerMock->create(TokenRequest::class);
        $object->setClientId('dasdasd')
            ->setClientSecret('asdasd')
            ->setCode('sadasd');
        $this->assertInstanceOf(ErrorResponseInterface::class, $this->requestProcessor->process($object));
    }

    public function testAuthenticationReturnsToken()
    {
        $this->zendHttpResponse->method('getBody')
            ->willReturn(
                '{"access_token":"BEARER","expires_in":86400,"refresh_token":"9YORmXHgOI32k"}'
            );

        $authentication = $this->getAuthenticationMock();
        /** @var TokenResponse $result */
        $result = $authentication->getAuthenticationToken();
        $this->assertInstanceOf(TokenResponse::class, $result);

        $this->assertSame('BEARER', $result->getAccessToken());
        $this->assertSame(86400, $result->getExpiresIn());
        $this->assertSame('9YORmXHgOI32k', $result->getRefreshToken());
    }

    public function testAuthenticationWithExpiredCodeThrowsException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->zendHttpResponse->method('getBody')
            ->willReturn(
                '{"errors":[{"error_type":"EXPIRED_CODE_GRANT","error_message":"The authorization code grant has expired."}]}'
            );

        $this->zendHttpResponse->method('isError')
            ->willReturn(true);

        $this->getAuthenticationMock()->getAuthenticationToken();
    }

    /**
     * @return Authentication|object
     */
    private function getAuthenticationMock(): Authentication
    {
        $objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $token = new TokenRequest();
        $token->setClientId('S')
            ->setClientSecret('S')
            ->setCode('S');
        return $objectManagerHelper->getObject(Authentication::class, [
            'requestProcessor' => $this->requestProcessor,
            'token' => $token,
        ]);
    }
}
