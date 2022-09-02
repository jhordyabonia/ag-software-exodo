<?php
declare(strict_types=1);

namespace AgSoftware\StorePickup\Controller\Adminhtml\Storepickup;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;

//use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class Data extends  \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AgSoftware_StorePickup::top_level';
    const COUNTRYID = 'agsoftware_storepickup_country_id';
    const DEPARTAMENTOID = 'agsoftware_storepickup_departamento_id';
    const PROVINCIAID = 'agsoftware_storepickup_provincia_id';
    const DISTRITOID = 'agsoftware_storepickup_distrito_id';

    protected $jsonResultFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Quote\Api\CartRepositoryInterface $carRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Directory\Model\ResourceModel\Region\Collection $region,
        DataPersistorInterface $dataPersistor)
    {
        $this->dataPersistor = $dataPersistor;
        $this->region = $region;
        $this->countryFactory = $countryFactory;
        $this->customerSession =  $customerSession;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_resourceConnection = $resourceConnection;
        parent::__construct($context);
        $this->execute();
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = json_decode($this->getRequest()->getContent(),true);
        if(!isset($request['country'])){
            $request['country'] = 'US';
        }

        if(isset($request['departamento'])){
            $this->dataPersistor->set(\AgSoftware\StorePickup\Controller\Adminhtml\Storepickup\Data::PROVINCIAID,$request['departamento']);
            $data = $this->getProvincia($request['departamento'],$request['country']);
        }elseif(isset($request['provincia'])){
            $this->dataPersistor->set(\AgSoftware\StorePickup\Controller\Adminhtml\Storepickup\Data::PROVINCIAID,$request['provincia']);
            $data = $this->getDistritos($request['provincia'],$request['country']);
        }else{
            $this->dataPersistor->set(\AgSoftware\StorePickup\Controller\Adminhtml\Storepickup\Data::COUNTRYID,$request['country']);
            $data = $this->getDepartamentos($request['country']);
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $result
         */
        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        //$result->
        echo json_encode($data,JSON_OBJECT_AS_ARRAY);
        die;
        return $result;
    }

    public function getDepartamentos($country){
        $out = [];
        $this->region->addFieldToFilter('country_id', ['eq' => $country]);
        /**
         * @var \Magento\Directory\Model\Region $region
         */
        foreach ($this->region->load() as $key => $region){
            $out [] = ["label"=>$region->getName(),"value"=>$region->getId()];
        }
        return $out;
    }

    public function getProvincia($state_id,$country_id='CO') {
        $cities = [];
        /*if( $state_id!=""){
            $cities_options = $this->_cityFactory->create()->getCollection()
                ->addFieldToFilter('state_id',$state_id)
                ->addFieldToFilter('country_id',$country_id)
                ->addFieldToFilter('status',1);
            $cities_options->getSelect()
                ->order('city ASC');
            if($cities_options->count() > 0){
                foreach($cities_options as $city){
                    $cities[] = ['label'=>$city->getCity(),'value'=>$city->getId()];
                }
            }
        }*/
        return $cities;
      }


    public function getDistritos($state_id,$country_id='CO') {
        $cities = [];
        /*
        if( $state_id!=""){
            $cities_options = $this->_cityFactory->create()->getCollection()
                ->addFieldToFilter('state_id',$state_id)
                ->addFieldToFilter('country_id',$country_id)
                ->addFieldToFilter('status',1);
            $cities_options->getSelect()
                ->order('city ASC');
            if($cities_options->count() > 0){
                foreach($cities_options as $city){
                    $cities[] = ['label'=>$city->getCity(),'value'=>$city->getId()];
                }
            }
        }*/
        return $cities;
    }


    /**
     * Check the permission to run it.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AgSoftware_StorePickup::store_pickup_view');
    }

}

