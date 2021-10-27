<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data\Legacy;

class FormIntegrations extends \Magento\Framework\DataObject implements FormIntegrationsInterface
{

    /**
     * @param string $name
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setName(string $name): FormIntegrationsInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $email
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setEmail(string $email): FormIntegrationsInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param string $identificador
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setIdentificador(string $identificador): FormIntegrationsInterface
    {
        return $this->setData(self::IDENTIFICADOR, $identificador);
    }

    /**
     * @return string
     */
    public function getIdentificador(): string
    {
        return $this->getData(self::IDENTIFICADOR);
    }

    /**
     * @param string $pageTitle
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setPageTitle(string $pageTitle): FormIntegrationsInterface
    {
        return $this->setData(self::PAGE_TITLE, $pageTitle);
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->getData(self::PAGE_TITLE);
    }

    /**
     * @param string $formUrl
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setFormUrl(string $formUrl): FormIntegrationsInterface
    {
        return $this->setData(self::FORM_URL, $formUrl);
    }

    /**
     * @return string
     */
    public function getFormUrl(): string
    {
        return $this->getData(self::FORM_URL);
    }

    /**
     * @param string $clientId
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setClientId(string $clientId): FormIntegrationsInterface
    {
        return $this->setData(self::CLIENT_ID, $clientId);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getData(self::CLIENT_ID);
    }

    /**
     * @param string $tokenRDStation
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setTokenRdstation(string $tokenRDStation): FormIntegrationsInterface
    {
        return $this->setData(self::TOKEN_RDSTATION, $tokenRDStation);
    }

    /**
     * @return string
     */
    public function getTokenRdstation(): string
    {
        return $this->getData(self::TOKEN_RDSTATION);
    }

    /**
     * @param array $tags
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setTags(array $tags): FormIntegrationsInterface
    {
        return $this->setData(self::TAGS, $tags);
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->getData(self::TAGS);
    }

    /**
     * @return string
     */
    public function endpoint(): string
    {
        return 'form-integrations';
    }

    /**
     * @return string
     */
    public function responseType(): string
    {
        return 'string';
    }
}
