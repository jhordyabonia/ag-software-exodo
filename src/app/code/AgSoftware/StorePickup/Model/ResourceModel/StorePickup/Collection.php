<?php


namespace AgSoftware\StorePickup\Model\ResourceModel\StorePickup;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'AgSoftware\StorePickup\Model\StorePickup',
            'AgSoftware\StorePickup\Model\ResourceModel\StorePickup'
        );
    }
}
