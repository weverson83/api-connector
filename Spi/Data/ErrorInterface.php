<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;


use Omv\RDStation\Spi\Data\Error\ValidationRuleInterface;

interface ErrorInterface
{
    const ERROR_MESSAGE = 'error_message';
    const ERROR_TYPE = 'error_type';
    const VALIDATION_RULES = 'validation_rules';
    const PATH = 'path';

    const OAUTH = 'EXPIRED_CODE_GRANT';
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const ACCESS_DENIED = 'ACCESS_DENIED';
    const EXPIRED_CODE_GRANT = 'EXPIRED_CODE_GRANT';
    const INVALID_REFRESH_TOKEN = 'INVALID_REFRESH_TOKEN';
    const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    const UNSUPPORTED_MEDIA_TYPE = 'UNSUPPORTED_MEDIA_TYPE';
    const BAD_REQUEST = 'BAD_REQUEST';
    const CANNOT_BE_NULL = 'CANNOT_BE_NULL';
    const INVALID_FORMAT = 'INVALID_FORMAT';
    const CANNOT_BE_BLANK = 'CANNOT_BE_BLANK';
    const VALUES_MUST_BE_LOWERCASE = 'VALUES_MUST_BE_LOWERCASE';
    const MUST_BE_STRING = 'MUST_BE_STRING';
    const INVALID_FIELDS = 'INVALID_FIELDS';
    const CONFLICTING_FIELD = 'CONFLICTING_FIELD';
    const EMAIL_ALREADY_IN_USE = 'EMAIL_ALREADY_IN_USE';
    const INVALID = 'INVALID';
    const TAKEN = 'TAKEN';
    const TOO_SHORT = 'TOO_SHORT';
    const TOO_LONG = 'TOO_LONG';
    const EXCLUSION = 'EXCLUSION';
    const INCLUSION = 'INCLUSION';


    /**
     * @return string
     */
    public function getErrorMessage(): string;

    /**
     * @param string $errorMessage
     * @return $this
     */
    public function setErrorMessage(string $errorMessage): self;

    /**
     * @return string
     */
    public function getErrorType(): string;

    /**
     * @param string $errorType
     * @return $this
     */
    public function setErrorType(string $errorType): self;

    /**
     * @return \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface[]
     */
    public function getValidationRules(): array;

    /**
     * @param \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface[] $validationRules
     * @return \Omv\RDStation\Spi\Data\ErrorInterface
     */
    public function setValidationRules(array $validationRules): self;

    /**
     * @return string
     */
    public function getPath(): ?string;

    /**
     * @param string $path
     * @return \Omv\RDStation\Spi\Data\ErrorInterface
     */
    public function setPath(string $path): self;
}
