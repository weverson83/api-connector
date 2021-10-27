<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

use Magento\Framework\DataObject;
use Omv\RDStation\Spi\Data\Error\ValidationRuleInterface;

class ErrorResponse extends DataObject implements ErrorResponseInterface
{
    /**
     * @return \Omv\RDStation\Spi\Data\Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->getData(self::ERRORS);
    }

    /**
     * @param \Omv\RDStation\Spi\Data\Error[] $errors
     * @return \Omv\RDStation\Spi\Data\ErrorResponse
     */
    public function setErrors(array $errors): ErrorResponseInterface
    {
        return $this->setData(self::ERRORS, $errors);
    }

    /**
     * @param \Omv\RDStation\Spi\Data\Error $error
     * @return \Omv\RDStation\Spi\Data\ErrorResponse
     */
    public function addError(ErrorInterface $error): ErrorResponseInterface
    {
        $existingErrors = $this->getErrors();
        array_push($existingErrors, $error);

        return $this->setErrors($existingErrors);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(', ', array_map(function (ErrorInterface $error) {
            return $error->getErrorMessage();
        }, $this->getErrors()));
    }
}
