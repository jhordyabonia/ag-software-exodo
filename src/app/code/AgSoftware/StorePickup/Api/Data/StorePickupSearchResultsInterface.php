<?php


namespace AgSoftware\StorePickup\Api\Data;

interface StorePickupSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get store_pickup list.
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface[]
     */
    public function getItems();

    /**
     * Set country_id list.
     * @param \AgSoftware\StorePickup\Api\Data\StorePickupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
