<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data\Error;

interface ValidationRuleInterface
{
    const DATA_TYPE = 'DATA_TYPE';

    /**
     * @param string $dataType
     * @return \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface
     */
    public function setDataType(string $dataType): self;

    /**
     * @return string
     */
    public function getDataType(): string;
}
