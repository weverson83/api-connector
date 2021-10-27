<?php
declare(strict_types=1);

namespace Omv\RDStation\Spi\Data\Error;

use Magento\Framework\DataObject;

class ValidationRule extends DataObject implements ValidationRuleInterface
{

    /**
     * @param string $dataType
     * @return \Omv\RDStation\Spi\Data\Error\ValidationRuleInterface
     */
    public function setDataType(string $dataType): ValidationRuleInterface
    {
        return $this->setData(self::DATA_TYPE, $dataType);
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->getData(self::DATA_TYPE);
    }
}
