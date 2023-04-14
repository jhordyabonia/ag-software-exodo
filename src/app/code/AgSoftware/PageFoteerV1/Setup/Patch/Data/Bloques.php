<?php
/**
 * Copyright © N/A All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\PageFoteerV1\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class Bloques implements DataPatchInterface, PatchRevertableInterface 
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct (
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Model\BlockFactory $cmsBlock,
        \Magento\Cms\Api\BlockRepositoryInterface $cmsRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->cmsBlock = $cmsBlock;
        $this->cmsRepository = $cmsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        
        $this->moduleDataSetup->getConnection()->startSetup();

        /**
         * @var \Magento\Cms\Model\Block $cmsBlock
         */
        
        $data = [];
        $data[ 'pree-footer-weltpixel' ] = [
            "title" => "pree footer weltpixel",
            "identifier" => "pree-footer-weltpixel",
            "content" => file_get_contents(__DIR__.'/html/preFooter.html'),
            "is_active" => "1"
        ];
        $data[ 'footer-weltpixel' ] = [
            "title" => "footer weltpixel",
            "identifier" => "footer-weltpixel",
            "content" => file_get_contents(__DIR__.'/html/footer.html'),
            "is_active" => "1"
        ];

        
        foreach ( $data as $item) {

            $cmsBlockFooter = $this->cmsBlock->create();

            $cmsBlockFooter->addData($item);

            $this->cmsRepository->save($cmsBlockFooter);

        }

        $this->moduleDataSetup->getConnection()->endSetup();

    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
    */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
    */
    public static function getDependencies()
    {
        return [

        ];
    }
    
}