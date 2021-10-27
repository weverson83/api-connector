<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

use Magento\Framework\DataObject;
use Omv\RDStation\Spi\Data\Error\ValidationRuleInterface;

class Error extends DataObject implements ErrorInterface
{

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->getData(self::ERROR_MESSAGE);
    }

    /**
     * @param string $errorMessage
     * @return \Omv\RDStation\Spi\Data\Error
     */
    public function setErrorMessage(string $errorMessage): ErrorInterface
    {
        return $this->setData(self::ERROR_MESSAGE, $errorMessage);
    }

    /**
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->getData(self::ERROR_TYPE);
    }

    /**
     * @param string $errorType
     * @return \Omv\RDStation\Spi\Data\Error
     */
    public function setErrorType(string $errorType): ErrorInterface
    {
        return $this->setData(self::ERROR_TYPE, $errorType);
    }

    /**
     * @return \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface[]
     */
    public function getValidationRules(): array
    {
        return $this->getData(self::VALIDATION_RULES);
    }

    /**
     * @param \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface[] $validationRules
     * @return \Omv\RDStation\Spi\Data\ErrorInterface
     */
    public function setValidationRules(array $validationRules): ErrorInterface
    {
        return $this->setData(self::VALIDATION_RULES, $validationRules);
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->getData(self::PATH);
    }

    /**
     * @param string $path
     * @return \Omv\RDStation\Spi\Data\ErrorInterface
     */
    public function setPath(string $path): ErrorInterface
    {
        return $this->setData(self::PATH, $path);
    }
}
