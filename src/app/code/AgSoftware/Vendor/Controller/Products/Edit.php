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

class Edit implements HttpGetActionInterface
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
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory)
    {
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->request = $request;
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
            $product =  $this->productRepository->get($sku);
            if($product->getId()){
                if($customerId !== $product->getData('agsoftware_vendor_id')){
                    $this->messageManager->addErrorMessage(__("El producto %1 no te pertenece, el incidente será reportado", $sku));
                    $redirect->setUrl('/vendor/products');
                    return $redirect;
                }
            }
        }

        $page = $this->resultPageFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        $product = $this->productRepository->get($this->request->getParam('product'));
        if($product->getId()) {
            $page->getLayout()->getBlock("products.edit")
                ->setData('product', $product);
        }
        return $page;
    }
}

