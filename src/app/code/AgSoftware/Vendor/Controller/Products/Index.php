<?php
/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Vendor\Controller\Products;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    private \Magento\Catalog\Model\ResourceModel\Product\Collection $collection;
    protected \Magento\Customer\Model\Session $customerSession;
    protected \Magento\Framework\App\RequestInterface $request;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $collection,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory)
    {
        $this->request = $request;
        $this->collection = $collection;
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $redirect = $this->resultPageFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $customerId = $this->customerSession->getCustomer()->getId();
        if(!$customerId){
            $redirect->setUrl('/customer/account/login');
            return $redirect;
        }

        $this->collection->addAttributeToSelect('gsoftware_vendor_id,name,price,special_price,status')
                        ->addAttributeToFilter('name',['like'=>"%"])
                        ->addAttributeToFilter('price',['like'=>"%"])
                        ->addAttributeToFilter('status',['like'=>"%"])
                        ->addAttributeToFilter('agsoftware_vendor_id',$customerId)
                        ->joinField('qty', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id', 'qty>=0')
                        ->setFlag('has_stock_status_filter', true)
                        ->load();

        $page = $this->resultPageFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        $page->getLayout()->getBlock("products.index")
            ->setData('collection',$this->collection);
        //print_r($this->colletion->getData());
        //print_r($this->scopeConfig->getValue('payment/mercadopago'));
        //die;
        return $page;
    }
}

