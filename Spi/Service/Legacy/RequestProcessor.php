<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Service\Legacy;

use Omv\RDStation\Spi\Data\Legacy\FormIntegrationsResponse;
use Omv\RDStation\Spi\Data\ResponseInterface;

class RequestProcessor extends \Omv\RDStation\Spi\Service\RequestProcessor
{
    const HTTPS_API_RD_SERVICES = 'https://www.rdstation.com.br/api/1.3/';

    protected function extractResponseData(\Zend_Http_Response $httpResponse, string $type): ResponseInterface
    {
        return new FormIntegrationsResponse();
    }
}
