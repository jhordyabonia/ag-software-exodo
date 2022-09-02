<?php


namespace AgSoftware\StorePickup\Model\ResourceModel;

class StorePickup extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('agsoftware_storepickup', 'store_pickup_id');
    }
}
