<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AgSoftware\StorePickup\Model;

class CheckoutConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Checkout\Model\Session $checkoutSession,
        \AgSoftware\StorePickup\Model\StorePickupFactory $storeCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \AgSoftware\StorePickup\Model\Config\Source\Departamentos $departamentos/*,
        \Custom\City\Model\CityFactory $_cityFactory*/
    ) {

        //$this->_cityFactory = $_cityFactory;
        $this->departamentos = $departamentos;
        $this->scopeConfig = $scopeConfig;
        $this->_resourceConnection = $resourceConnection;
        $this->checkoutSession = $checkoutSession;
        $this->_storeCollectionFactory = $storeCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $config = [];

        $config['storepickup'] = [
            'loadedStores' => $this->getStores()
        ];

        return $config;
    }

    protected function getExtraData($store){
        $store['departamento_n'] = $this->departamentos->getOptionText($store['departamento']);
        $store['provincia_n'] = $store['provincia'];
        $store['distrito_n'] = '';//$this->_cityFactory->create()->load($store['distrito'])->getData('city');
        $store['label'] = $store['name'];
        return $store;
    }

    protected function getStores(){
        /** @var \AgSoftware\StorePickup\Model\StorePickup\Collection $collection */
        $collection = $this->_storeCollectionFactory->create()->getCollection()
                        ->addFieldToSelect('*')
                        ->addFieldToFilter('active',1)
                        ;

        $storesData = [];
        foreach($collection as $option){
            if($option->getStores() != null){
                if( in_array($this->getStoreCode(),$option->getStores())){
                    $storesData[] = $this->getExtraData($option->getData());
                }
            }
        }

        return [
                'active' => $this->scopeConfig->getValue('carriers/store_pickup/active'),
                'storeslist' => $storesData,
                'selectedstore'=>$this->checkoutSession->getData('store_pickup'),
                'num_store' => count($storesData)
            ];
    }
    /**
     * @return string
     */
    private function getStoreCode() {
        $storeCode = $this->storeManager->getStore()->getCode();
        return $storeCode;
    }
}
