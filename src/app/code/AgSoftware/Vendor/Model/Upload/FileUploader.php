<?php

/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace  AgSoftware\Vendor\Model\Upload;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ImageFileUploader
 * @package Aheadworks\Rbslider\Model\Slide
 */
class FileUploader
{
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var string
     */
    const FILE_DIR = 'agsoftware_vendor/uploads';

    /**
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
    }

    /**
     * Save file to temp media directory
     *
     * @param string $fileId
     * @return array
     * @throws LocalizedException
     */
    public function saveFileToMediaFolder($fileId)
    {
        try {
            $result = ['file' => '', 'size' => ''];
            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath(self::FILE_DIR);
            /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);
            $uploader->setAllowedExtensions($this->getAllowedExtensions($fileId));
            $result = array_intersect_key($uploader->save($mediaDirectory), $result);

            $result['url'] = $this->getMediaUrl($result['file']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }

    /**
     * Get file url
     *
     * @param string $file
     * @return string
     */
    public function getMediaUrl($file)
    {
        $file = ltrim(str_replace('\\', '/', $file), '/');
        return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . self::FILE_DIR . '/' . $file;
    }

    /**
     * Get allowed file extensions
     *
     * @return string[]
     */
    public function getAllowedExtensions($typeFile)
    {
        if('image-product' === $typeFile) {
            return ['jpg', 'jpeg', 'gif', 'png'];
        }else{
            return ['zip'];
        }
    }
}
