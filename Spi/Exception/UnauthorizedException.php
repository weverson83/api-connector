<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Exception;

class UnauthorizedException extends \Exception
{
    protected $code = 401;
}
