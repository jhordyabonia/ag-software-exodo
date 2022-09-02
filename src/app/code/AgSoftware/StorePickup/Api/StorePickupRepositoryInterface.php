<?php


namespace AgSoftware\StorePickup\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface StorePickupRepositoryInterface
{


    /**
     * Save store_pickup
     * @param \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
    );

    /**
     * Retrieve store_pickup
     * @param string $storePickupId
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($storePickupId);

    /**
     * Retrieve store_pickup matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete store_pickup
     * @param \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
    );

    /**
     * Delete store_pickup by ID
     * @param string $storePickupId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($storePickupId);
}
