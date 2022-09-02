<?php


namespace AgSoftware\StorePickup\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;

class StorePickup extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{

    protected $_code = 'store_pickup';

    protected $_isFixed = true;

    protected $_rateResultFactory;

    protected $_rateMethodFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \AgSoftware\StorePickup\Model\StorePickupFactory $storeCollection,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_storeCollection = $storeCollection;
        $this->dataPersistor = $dataPersistor;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $shippingPrice = $this->getConfigData('price');

        $method = $this->_rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));
        $store_name = $this->dataPersistor->get('store_pickup');
        $store = $this->_storeCollection->create()->load($store_name, 'name');
        if($store_name&&$store->getId()){
            $shippingPrice = $store->getPrice();
        }
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->getQuote($request);
        //throw new \Exception("here");
        if($store->getFree()){
            if($quote->getSubTotal()>$store->getFree()){
                $shippingPrice = 0;
            }
        }

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result = $this->_rateResultFactory->create();
        $result->append($method);

        return $result;
    }

    /**
     * @param $request
     * @return null
     */
    protected function getQuote($request){
        $quote = null;
        foreach ($request->getAllItems() as $item){
            $quote = $item->getQuote();
            if ($quote){
                break;
            }
        }
        return $quote;
    }

    /**
     * getAllowedMethods
     *
     * @param array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
