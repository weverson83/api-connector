<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Service;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClient;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Webapi\ServiceInputProcessor;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use Omv\RDStation\Spi\Data\ErrorResponse;
use Omv\RDStation\Spi\Data\RequestInterface;
use Omv\RDStation\Spi\Data\ErrorInterface;
use Omv\RDStation\Spi\Data\ErrorResponseInterface;
use Omv\RDStation\Spi\Data\ResponseInterface;
use Omv\RDStation\Spi\Data\TokenResponse;
use Omv\RDStation\Spi\Exception\ErrorException;
use Omv\RDStation\Spi\Exception\UnauthorizedException;

class RequestProcessor
{
    const HTTPS_API_RD_SERVICES = 'https://api.rd.services/';
    /**
     * @var ServiceInputProcessor
     */
    private $serviceInputProcessor;
    /**
     * @var ServiceOutputProcessor
     */
    private $serviceOutputProcessor;
    /**
     * @var MethodsMap
     */
    private $methodsMapProcessor;
    /**
     * @var ZendClientFactory
     */
    private $httpClientFactory;
    /**
     * @var Json
     */
    private $json;
    /**
     * @var TokenResponse
     */
    private $token;

    /**
     * RequestProcessor constructor.
     * @param ServiceInputProcessor $serviceInputProcessor
     * @param ServiceOutputProcessor $serviceOutputProcessor
     * @param MethodsMap $methodsMapProcessor
     * @param ZendClientFactory $httpClientFactory
     * @param Json $json
     */
    public function __construct(
        ServiceInputProcessor $serviceInputProcessor,
        ServiceOutputProcessor $serviceOutputProcessor,
        MethodsMap $methodsMapProcessor,
        ZendClientFactory $httpClientFactory,
        Json $json,
        TokenResponse $token = null
    ) {
        $this->serviceInputProcessor = $serviceInputProcessor;
        $this->serviceOutputProcessor = $serviceOutputProcessor;
        $this->methodsMapProcessor = $methodsMapProcessor;
        $this->httpClientFactory = $httpClientFactory;
        $this->json = $json;
        $this->token = $token;
    }

    /**
     * @param RequestInterface $request
     * @param string $method
     * @return ResponseInterface
     * @throws LocalizedException
     * @throws \Zend_Http_Client_Exception
     * @throws UnauthorizedException
     */
    public function process(RequestInterface $request, string $method = \Zend_Http_Client::POST): ResponseInterface
    {
        $response = $this->makeRequest(
            $request->endpoint(),
            $method,
            $this->extractRequestData($request)
        );

        $response = $this->extractResponseData(
            $response,
            $request->responseType()
        );

        $this->handleOAuthError($response);

        return $response;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws InputException
     */
    protected function extractRequestData(RequestInterface $request): array
    {
        return $this->serviceOutputProcessor->convertValue(
            $request,
            $this->getContractInterface($request)
        );
    }

    /**
     * @param \Zend_Http_Response $httpResponse
     * @param string $type
     * @return ResponseInterface
     * @throws LocalizedException
     */
    protected function extractResponseData(\Zend_Http_Response $httpResponse, string $type): ResponseInterface
    {
        if (class_exists($type) && !in_array(ResponseInterface::class, class_implements($type))) {
            throw new InputException(__('The object type must implement ResponseInterface.'));
        }

        $responseBody = $this->json->unserialize($httpResponse->getBody());

        if ($httpResponse->isError()) {
            return $this->serviceInputProcessor->convertValue(
                $responseBody,
                \Omv\RDStation\Spi\Data\ErrorResponseInterface::class
            );
        }
        return $this->serviceInputProcessor->convertValue(
            $responseBody,
            $type
        );
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $requestData
     * @return \Zend_Http_Response
     * @throws \Zend_Http_Client_Exception
     */
    private function makeRequest(string $endpoint, string $method, array $requestData): \Zend_Http_Response
    {
        /** @var ZendClient $client */
        $client = $this->httpClientFactory->create();
        $client->setUri(static::HTTPS_API_RD_SERVICES . $endpoint);
        $client->setConfig([
            'maxredirects' => 3,
            'timeout' => 30,
        ]);
        $client->setMethod($method);
        $client->setHeaders('Content-Type', 'application/json');

        if ($this->token) {
            $client->setHeaders('Authorization', 'Bearer ' . $this->token->getAccessToken());
        }

        $client->setUrlEncodeBody(false);
        $client->setRawData($this->json->serialize($requestData));

        return $client->request();
    }

    /**
     * @param ResponseInterface $response
     * @throws UnauthorizedException
     * @throws ErrorException
     */
    private function handleOAuthError(ResponseInterface $response): void
    {
        if ($response instanceof ErrorResponseInterface) {
            foreach ($response->getErrors() as $error) {
                if ($error->getErrorType() === ErrorInterface::OAUTH) {
                    throw new UnauthorizedException($error->getErrorMessage());
                }
            }

            throw new ErrorException($response);
        }
    }

    /**
     * @param object $object
     * @return string
     */
    private function getContractInterface(object $object): string
    {
        $reflection = new \ReflectionClass($object);
        $interfaces = $reflection->getInterfaceNames();
        $objectClass = explode('\\', get_class($object));
        $objectClass = end($objectClass);
        foreach ($interfaces as $interfaceName) {
            $interface = explode('\\', $interfaceName);
            $interface = end($interface);
            if ($interface === $objectClass . 'Interface') {
                return $interfaceName;
            }
        }

        return $interfaces[1];
    }
}
