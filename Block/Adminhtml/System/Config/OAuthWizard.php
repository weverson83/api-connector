<?php
declare(strict_types=1);

namespace Omv\RDStation\Block\Adminhtml\System\Config;

use Omv\RDStation\Model\Config;

class OAuthWizard extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Path to block template
     */
    const WIZARD_TEMPLATE = 'Omv_RDStation::system/config/oauth_wizard.phtml';

    /**
     * Set template to itself
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate(static::WIZARD_TEMPLATE);
        }
        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $clientId = $this->_scopeConfig->getValue(Config::CFG_CLIENT_ID);
        $redirectUrl = $this->getUrl('rdstation/oauth/callback', ['_nosecret' => true]);
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'button_url' => 'https://app.rdstation.com.br/api/platform/auth?client_id=' . $clientId . '&redirect_uri=' . urlencode($redirectUrl),
                'html_id' => $element->getHtmlId(),
            ]
        );
        return $this->_toHtml();
    }
}
