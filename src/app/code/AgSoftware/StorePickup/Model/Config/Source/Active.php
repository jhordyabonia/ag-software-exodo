<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Active extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{ 

    /**
     * {@inheritdoc}
     */
    public function getAllOptions()
    {
        return [
            ['label' => __('Active'), 'value' => 1],
            ['label' => __('Inactive'), 'value' => 0]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}
