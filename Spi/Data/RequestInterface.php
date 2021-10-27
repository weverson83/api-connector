<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data;

interface RequestInterface
{

    /**
     * @return string
     */
    public function endpoint(): string;

    /**
     * @return string
     */
    public function responseType(): string;
}
