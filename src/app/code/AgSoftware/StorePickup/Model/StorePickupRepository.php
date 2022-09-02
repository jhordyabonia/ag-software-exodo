<?php


namespace AgSoftware\StorePickup\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use AgSoftware\StorePickup\Model\ResourceModel\StorePickup\CollectionFactory as StorePickupCollectionFactory;
use AgSoftware\StorePickup\Api\Data\StorePickupInterfaceFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use AgSoftware\StorePickup\Api\Data\StorePickupSearchResultsInterfaceFactory;
use AgSoftware\StorePickup\Api\StorePickupRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use AgSoftware\StorePickup\Model\ResourceModel\StorePickup as ResourceStorePickup;

class StorePickupRepository implements StorePickupRepositoryInterface
{

    protected $dataStorePickupFactory;

    protected $resource;

    protected $dataObjectHelper;

    protected $storePickupFactory;

    private $storeManager;

    protected $dataObjectProcessor;

    protected $searchResultsFactory;

    protected $storePickupCollectionFactory;


    /**
     * @param ResourceStorePickup $resource
     * @param StorePickupFactory $storePickupFactory
     * @param StorePickupInterfaceFactory $dataStorePickupFactory
     * @param StorePickupCollectionFactory $storePickupCollectionFactory
     * @param StorePickupSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceStorePickup $resource,
        StorePickupFactory $storePickupFactory,
        StorePickupInterfaceFactory $dataStorePickupFactory,
        StorePickupCollectionFactory $storePickupCollectionFactory,
        StorePickupSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->storePickupFactory = $storePickupFactory;
        $this->storePickupCollectionFactory = $storePickupCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataStorePickupFactory = $dataStorePickupFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
    ) {
        /* if (empty($storePickup->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $storePickup->setStoreId($storeId);
        } */
        try {
            $this->resource->save($storePickup);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the storePickup: %1',
                $exception->getMessage()
            ));
        }
        return $storePickup;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($storePickupId)
    {
        $storePickup = $this->storePickupFactory->create();
        $this->resource->load($storePickup, $storePickupId);
        if (!$storePickup->getId()) {
            throw new NoSuchEntityException(__('store_pickup with id "%1" does not exist.', $storePickupId));
        }
        return $storePickup;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->storePickupCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AgSoftware\StorePickup\Api\Data\StorePickupInterface $storePickup
    ) {
        try {
            $this->resource->delete($storePickup);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the store_pickup: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($storePickupId)
    {
        return $this->delete($this->getById($storePickupId));
    }
}
