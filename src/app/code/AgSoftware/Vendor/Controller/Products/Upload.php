<?php
/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Vendor\Controller\Products;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use AgSoftware\Vendor\Model\Upload\FileUploader;

class Upload  implements HttpPostActionInterface
{
    /**
     * @var ImageFileUploader
     */
    private $imageFileUploader;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;


    /**
     * @param ImageFileUploader $imageFileUploader
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\ResultFactory  $resultPageFactory,
        FileUploader $imageFileUploader

    ) {
        $this->requets = $request;
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->imageFileUploader = $imageFileUploader;

    }

    /**
     * Image upload action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $type = $this->requets->getParam('type');
        $result = $this->imageFileUploader->saveFileToMediaFolder($type);
        if(isset($result['url'])) {
            if($type === 'image-product') {
                $images = $this->customerSession->getProductImage($result['url']);
                if ($images == null) {
                    $images = [];
                }
                $images[count($images)] = $result['url'];
                $this->customerSession->setProductImage($images);
            }else{
                $this->customerSession->setProductZip($result['url']);
            }

        }
        return $this->resultPageFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}

