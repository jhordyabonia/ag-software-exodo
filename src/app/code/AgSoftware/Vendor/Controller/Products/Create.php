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

class Create implements HttpGetActionInterface
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
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Controller\ResultFactory $resultPageFactory)
    {
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
        $this->productFactory = $productFactory;
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

        $page = $this->resultPageFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $product = $this->productFactory->create();
        $product->setData($this->customerSession->getRequest());
        $page->getLayout()->getBlock("products.edit")
            ->setData('product', $product);
        return $page;
    }
}

