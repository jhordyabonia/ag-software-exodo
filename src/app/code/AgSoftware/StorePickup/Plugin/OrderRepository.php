<?php

namespace AgSoftware\StorePickup\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderRepositoryPlugin
 */
class OrderRepository
{
    /**
     * Order store_pickup field name
     */
    const FIELD_NAME = 'store_pickup';

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    private \AgSoftware\StorePickup\Logger\Logger $_logger;

    /**
     * OrderRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(
        \AgSoftware\StorePickup\Logger\Logger $logger,
        OrderExtensionFactory $extensionFactory)
    {
        $this->_logger = $logger;
        $this->extensionFactory = $extensionFactory;

    }

    /**
     * Add "store_pickup" extension attribute to order data object to make it accessible in API data of order record
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
       try{
            $extensionAttributes = $order->getExtensionAttributes();
            $paymentAdditionalInformation = $order->getPayment()->getAdditionalInformation();
            if(isset($paymentAdditionalInformation['store_pickup'])) {
                $store_pickup = $paymentAdditionalInformation['store_pickup'];
                $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
                $extensionAttributes->setStorePickup($store_pickup);
                $order->setExtensionAttributes($extensionAttributes);
            }
        }catch(\Exception $e){
            $this->_logger->info("order ".$order->getIncrementId()." ".$e->getTraceAsString());
        }

        return $order;
    }

    /**
     * Add "store_pickup" extension attribute to order data object to make it accessible in API data of all order list
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            try{
                //store_pickup
                $extensionAttributes = $order->getExtensionAttributes();
                $paymentAdditionalInformation = $order->getPayment()->getAdditionalInformation();
                if(isset($paymentAdditionalInformation['store_pickup'])) {
                    $store_pickup = $paymentAdditionalInformation['store_pickup'];
                    $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
                    $extensionAttributes->setStorePickup($store_pickup);
                    $order->setExtensionAttributes($extensionAttributes);
                }

            }catch(\Exception $e){
                $this->_logger->info("order ".$order->getIncrementId()." ".$e->getTraceAsString());
            }
        }

        return $searchResult;
    }
}
