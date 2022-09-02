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

class Delete implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory)
    {
        $this->state = $state;
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->customerSession = $customerSession;
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

        $sku = $this->request->getParam('product');
        if($sku){
            /**
             * @var \Magento\Catalog\Api\Data\ProductInterface $product
             */
            $product =  $this->productRepository->get($sku);
            if($product->getId()){
                if($customerId === $product->getData('agsoftware_vendor_id')){
                    $date = date('Ymdihs');
                    $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
                    $product->setData('sku',$sku."-$customerId");
                    $product->setData('store_id',0);
                    $product->setData('name',$product->getName(). " (Delete {$date})");
                    $product->setData('url_key','');
                    $product->setData('url_key_create_redirect',1);
                    $product->setData('agsoftware_vendor_id',-$customerId);
                    $this->productRepository->save($product);
                    $this->messageManager->addSuccessMessage(__("Producto, %1 eliminado",$sku));
                }else{
                    $this->messageManager->addErrorMessage(__("El producto %1 no te pertenece, el incidente será reportado", $sku));
                }
            }
        }

        $redirect->setUrl('/vendor/products');
        return $redirect;
    }
}

