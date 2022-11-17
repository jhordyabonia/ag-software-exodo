<?php
/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Vendor\Controller\Products;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Save implements HttpPostActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    private \Magento\Framework\App\RequestInterface $requets;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Downloadable\Api\Data\LinkInterfaceFactory $link,
        \Magento\Downloadable\Api\LinkRepositoryInterface $linkRepository,
        \Magento\Framework\App\Filesystem\DirectoryList $mediaDir,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\ResultFactory  $resultPageFactory)
    {
        $this->mediaDir = $mediaDir->getPath('media');
        $this->linkRepository =  $linkRepository;
        $this->linkFactory = $link;
        $this->redirect = $redirect;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->requets = $request;
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
        if (!$customerId) {
            $redirect->setUrl('/customer/account/login');
            return $redirect;
        }

        $data = $this->requets->getParams();
        $sku = $data['sku'];
        $isNew = true;
        if ($sku) {
            try {
                $product = $this->productRepository->get($sku);

                $isNew = strpos($this->redirect->getRefererUrl(), 'vendor/products/create');

                if ($product->getId()) {
                    if ($customerId !== $product->getData('agsoftware_vendor_id')) {
                        if ($isNew) {
                            $this->messageManager->addErrorMessage(__("Ya existe un producto  con sku %1", $sku));
                            $redirect->setUrl('/vendor/products/create');
                        } else {
                            $this->messageManager->addErrorMessage(__("El producto %1 no te pertenece, el incidente será reportado", $sku));
                            $redirect->setUrl('/vendor/products');
                        }
                        return $redirect;
                    } else if ($isNew) {
                        $this->messageManager->addErrorMessage(__("Ya existe un producto  con sku %1", $sku));
                        $this->customerSession->setData('request', $data);
                        $redirect->setUrl('/vendor/products/create');
                        return $redirect;
                    }
                }
            } catch (\Exception $e) {
                //$this->messageManager->addErrorMessage(__($e->getMessage()));
                //$this->customerSession->setData('request', $data);
            }
        }
        $data['agsoftware_vendor_id'] = $customerId;
        $data['type_id'] = \Magento\Downloadable\Model\Product\Type::TYPE_DOWNLOADABLE;
        $data['visibility'] = 4;
        $data['attribute_set_id'] = 4; // Default attribute set for products

        if ($isNew) {
            $data['quantity_and_stock_status']['qty'] = 1000;
            $data['quantity_and_stock_status']['status'] = \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED;
            $data['quantity_and_stock_status']['is_in_stock'] = 1; //Atributo de publicacion
        }

        if (!isset($product)) {
             $product = $this->productFactory->create();
        }
        $product->addData($data);

        try {
            $product->setData('store_id',0);
            $product->setData('url_key','');
            $product->setData('url_key_create_redirect',1);
            $product->setData('links_purchased_separately',0);

            if($this->customerSession->getProductImage()) {
                foreach ($this->customerSession->getProductImage() as $image) {
                    $imgUrl = $this->prepareImage($image);
                    if($imgUrl) {
                        $product->addImageToMediaGallery($imgUrl, ['image', 'small_image', 'thumbnail'], false, false);
                    }
                }
                //$this->productRepository->save($product);
            }
            if ($this->productRepository->save($product)) {
                if($isNew) {
                    $this->messageManager->addSuccessMessage(__("OK, producto %1 creado",$product->getName()));
                }else{
                    $this->messageManager->addSuccessMessage(__("OK, producto %1 editado",$product->getName()));
                }
                $product = $this->productRepository->get($sku);
                $file = $this->customerSession->getProductZip();
                if($file) {
                    $file = $this->prepareModule($file);
                    if($file) {
                        /**
                         * @var \Magento\Downloadable\Api\Data\LinkInterface $link_interface
                         */
                        $link_interface  = $this->linkFactory->create();

                        $nameLink = '2.4.X';//$data['name_link'];

                        $link_interface->setPrice(0);
                        $link_interface->setNumberOFDownloads(0);
                        $link_interface->setIsShareable(0);
                        $link_interface->setLinkType(\Magento\Downloadable\Helper\Download::LINK_TYPE_FILE);
                        $link_interface->setSortOrder(1);
                        $link_interface->setTitle($nameLink);
                        $link_interface->setData('link_file',$file);
                        $link_interface->setData('product_id',$product->getId());
                        $link_interface->save();
                        //$this->linkRepository->save($product->getSku(),$link_interface);
                    }
                }
            } else {
                $this->messageManager->addErrorMessage(__("No se pudo guardar el produto, contacta con administracíon"));
            }

        }catch (\Exception $e){
            $this->messageManager->addErrorMessage("Err ". $e->getMessage());
            $redirect->setUrl($this->redirect->getRefererUrl());
            return $redirect;
        }
        $this->customerSession->setData('request',[]);
        $this->customerSession->setProductImage([]);
        $this->customerSession->setProductZip('');
        $redirect->setUrl('/vendor/products');
        return $redirect;
    }

    private function prepareImage($imagePath){
        $imageFilename = basename($imagePath);
        $image_type = substr(strrchr($imageFilename, "."), 1);
        $filename = md5($imagePath . strtotime('now')) . '.' . $image_type;
        $filepath = $this->mediaDir . '/catalog/product/' . $filename;
        if(file_exists($this->mediaDir.'/agsoftware_vendor/uploads/' . $imageFilename)) {
            rename(trim($this->mediaDir . '/agsoftware_vendor/uploads/' . $imageFilename), $filepath);
            return $filepath;
        }
        return "";
    }

    private function prepareModule($file){
        if($file) {
            $filename = basename($file);
            $extra_path = str_split($filename);
            $extra_path = strtolower($extra_path[0] . '/' . $extra_path[1]);
            $newFilepath = $this->mediaDir . '/downloadable/files/links/' .$extra_path . '/' . $filename;
            if(!file_exists($this->mediaDir . '/downloadable/files/links/' .$extra_path )) {
                mkdir($this->mediaDir . '/downloadable/files/links/' . $extra_path, 0777, true);
            }
            rename($this->mediaDir.'/agsoftware_vendor/uploads/' .$filename,$newFilepath);
            return $extra_path . '/' . $filename;
        }
        return false;
    }
}

