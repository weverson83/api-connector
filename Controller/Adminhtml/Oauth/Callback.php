<?php
declare(strict_types=1);

namespace Omv\RDStation\Controller\Adminhtml\Oauth;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

class Callback extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Omv_RDStation::rdstation';

    public function __construct(
        Action\Context $context
    ) {
        ObjectManager::getInstance()->get(\Magento\Backend\Model\UrlInterface::class)->turnOffSecretKey();
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        echo '<script>window.opener.document.getElementById(\'omv_rdstation_connection_oauth_code\').value = ' .
            $this->getRequest()->getParam('code'),
        '; window.close();</script>';

        exit;
    }
}
