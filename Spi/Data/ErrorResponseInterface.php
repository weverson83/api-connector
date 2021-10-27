<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

use Omv\RDStation\Spi\Data\Error\ValidationRuleInterface;

interface ErrorResponseInterface extends ResponseInterface
{
    const ERRORS = 'errors';

    /**
     * @return \Omv\RDStation\Spi\Data\ErrorInterface[]|null
     */
    public function getErrors(): ?array;

    /**
     * @param \Omv\RDStation\Spi\Data\ErrorInterface[] $errors
     * @return $this
     */
    public function setErrors(array $errors): self;

    /**
     * @param ErrorInterface $error
     * @return $this
     */
    public function addError(\Omv\RDStation\Spi\Data\ErrorInterface $error): self;
}
