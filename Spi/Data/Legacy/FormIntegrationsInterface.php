<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data\Legacy;

interface FormIntegrationsInterface extends \Omv\RDStation\Spi\Data\RequestInterface
{
    const NAME = 'name';
    const EMAIL = 'email';
    const IDENTIFICADOR = 'identificador';
    const PAGE_TITLE = 'page_title';
    const FORM_URL = 'form_url';
    const CLIENT_ID = 'client_id';
    const TOKEN_RDSTATION = 'token_rdstation';
    const TAGS = 'tags';

    /**
     * @param string $name
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setName(string $name): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $email
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setEmail(string $email): self;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $identificador
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setIdentificador(string $identificador): self;

    /**
     * @return string
     */
    public function getIdentificador(): string;

    /**
     * @param string $pageTitle
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setPageTitle(string $pageTitle): self;

    /**
     * @return string
     */
    public function getPageTitle(): string;

    /**
     * @param string $formUrl
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setFormUrl(string $formUrl): self;

    /**
     * @return string
     */
    public function getFormUrl(): string;

    /**
     * @param string $clientId
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setClientId(string $clientId): self;

    /**
     * @return string
     */
    public function getClientId(): string;

    /**
     * @param string $tokenRDStation
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setTokenRdstation(string $tokenRDStation): self;

    /**
     * @return string
     */
    public function getTokenRdstation(): string;

    /**
     * @param array $tags
     * @return \Omv\RDStation\Spi\Data\Legacy\FormIntegrationsInterface
     */
    public function setTags(array $tags): self;

    /**
     * @return string[]
     */
    public function getTags(): array;
}
