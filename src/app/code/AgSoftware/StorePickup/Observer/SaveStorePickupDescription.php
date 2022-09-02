<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_StorePickup
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace AgSoftware\StorePickup\Observer;

use Magento\Framework\Event\ObserverInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class SaveStorePickupDescription implements ObserverInterface
{
    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @codeCoverageIgnore
     */
    protected $customerSession;

    /**
     * @var \AgSoftware\StorePickup\Model\StorePickupRepository
     */
    protected $_storeCollection;
    /**
     * @var \Magento\Sales\Api\Data\OrderAddressInterface
     */
    protected $_orderAddressInterface;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \AgSoftware\StorePickup\Model\StorePickupRepository $storeCollection,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \AgSoftware\StorePickup\Logger\Logger $logger,
        \AgSoftware\StorePickup\Model\Config\Source\Departamentos $departamentos
    ){
        $this->departamentos = $departamentos;
        $this->checkoutSession = $checkoutSession;
        $this->_storeCollection = $storeCollection;
        $this->_orderRepository = $orderRepository;

        $this->_logger = $logger;
    }
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        $this->_logger->info("order ".$order->getIncrementId());
        try {
            if($order->getShippingMethod()) {
                $this->_logger->info("shipping ".$order->getShippingMethod());
                if ($order->getShippingMethod() == "store_pickup_store_pickup") {
                    $store_pickup = $this->checkoutSession->getData('store_pickup');
                    $this->_logger->info("store_pickup ".$store_pickup);
                    if($store_pickup){

                        $store = $this->_storeCollection->getById($store_pickup);
                        $this->_logger->info("name store ".$store->getData('name'));

                        //set shipping address
                        $datashipping = ['ag_address_number'=>'','ag_address_complement'=>''];
                        $datashipping['street'] = ["Recoger en Tienda Flores: ".$store->getData('name')." ".$store->getData('street'),'',''];
                        $datashipping['city'] = $store->getData('distrito');
                        $datashipping['region_id'] = $store->getData('departamento');
                        $datashipping['region'] = $this->departamentos->getOptionText($store->getData('departamento'));
                        $datashipping['postcode'] = $store->getData('postcode');
                        $datashipping['country_id'] = $store->getData('country_id');
                        if ($store->getTelephone()) {
                            $datashipping['telephone'] = $store->getTelephone();
                        } else {
                            unset($datashipping['telephone']);
                        }
                        $datashipping['save_in_address_book'] = 0;

                        $order->getShippingAddress()->addData($datashipping);

                        $paymentAdditionalInformation = $order->getPayment()->getAdditionalInformation();
                        $paymentAdditionalInformation['store_pickup'] =  $store_pickup;
                        $paymentAdditionalInformation['postcode'] =   $store->getData('postcode');
                        $paymentAdditionalInformation['tipo_despacho'] =   $store->getData('extra')." Te enviaremos un e-mail cuando esté confirmado.";
                        $order->getPayment()->setAdditionalInformation($paymentAdditionalInformation);
                        $this->_orderRepository->save($order);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_logger->info("order ".$order->getIncrementId()." ".$e->getTraceAsString());
        }
    }
}
