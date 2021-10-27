<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Exception;

use Omv\RDStation\Spi\Data\ErrorInterface;
use Omv\RDStation\Spi\Data\ErrorResponseInterface;
use Throwable;

class ErrorException extends \Exception
{
    public function __construct(ErrorResponseInterface $errorResponse, $code = 400, Throwable $previous = null)
    {
        $message = $this->extractMessages($errorResponse);
        parent::__construct(json_encode($message), $code, $previous);
    }

    /**
     * @param ErrorResponseInterface $errorResponse
     * @return mixed
     */
    private function extractMessages(ErrorResponseInterface $errorResponse)
    {
        return array_reduce($errorResponse->getErrors(), function (array $result, ErrorInterface $error) {
            $arr = [
                'Error type' => $error->getErrorType(),
                'Message' => $error->getErrorMessage(),
            ];

            if ($error->getPath()) {
                $arr['Path'] = $error->getPath();
            }

            if ($error->getValidationRules()) {
                $validationRules = [];
                foreach ($error->getValidationRules() as $validationRule) {
                    $validationRules[] = [
                        $validationRule,
                    ];
                }

                $arr['Validation rules'] = $validationRules;
            }

            $result[] = $arr;
            return $result;
        }, []);
    }
}
