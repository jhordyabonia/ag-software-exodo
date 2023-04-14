<?php
/**
 * Copyright © N/A All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Home\Setup\Patch\Data;

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
        $data[ 'themes-and-extencions' ] = [
            "title" => "themes and extencions",
            "identifier" => "themes-and-extencions",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/themesAndExtencions.html'),
            "is_active" => "1"
        ];
        $data[ 'vide-Home' ] = [
            "title" => "vide Home",
            "identifier" => "vide-Home",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/videHome.html'),
            "is_active" => "1"
        ];
        $data[ 'google-analytics-4' ] = [
            "title" => "google analytics 4",
            "identifier" => "google-analytics-4",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/googleAnalytics4.html'),
            "is_active" => "1"
        ];
        $data[ 'overflow-hidden' ] = [
            "title" => "overflow hidden",
            "identifier" => "overflow-hidden",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/overflowhidden.html'),
            "is_active" => "1"
        ];
        $data[ 'build-growth' ] = [
            "title" => "build growth",
            "identifier" => "build-growth",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/buildGrowth.html'),
            "is_active" => "1"
        ];
        $data[ 'support-documentation' ] = [
            "title" => "support documentation",
            "identifier" => "support-documentation",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/supportDocumentation.html'),
            "is_active" => "1"
        ];
        /* Reservado para BLOQU slider */
        $data[ 'quote-2' ] = [
            "title" => "quote 2",
            "identifier" => "quote-2",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/quote2.html'),
            "is_active" => "1"
        ];
        $data[ 'overflow-auto' ] = [
            "title" => "overflow auto",
            "identifier" => "overflow-auto",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/overflowauto.html'),
            "is_active" => "1"
        ];
        $data[ 'industry-partners' ] = [
            "title" => "industry partners",
            "identifier" => "industry-partners",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/industryPartnes.html'),
            "is_active" => "1"
        ];
        $data[ 'no-padding' ] = [
            "title" => "no padding",
            "identifier" => "no-padding",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/nopadding.html'),
            "is_active" => "1"
        ];
        $data[ 'cont-Wp2' ] = [
            "title" => "cont Wp2",
            "identifier" => "cont-Wp2",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/contWp2.html'),
            "is_active" => "1"
        ];
        $data[ 'customer-development' ] = [
            "title" => "customer development",
            "identifier" => "customer-development",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__ . '/html/customerDevelopment.html'),
            "is_active" => "1"
        ];
        $data[ 'marketing-merchandising' ] = [
            "title" => "marketing merchandising",
            "identifier" => "marketing-merchandising",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/marketingMerchandising.html'),
            "is_active" => "1"
        ];
        $data[ 'section-collapsible-8' ] = [
            "title" => "section collapsible 8",
            "identifier" => "section-collapsible-8",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/sectionCollapsible8.html'),
            "is_active" => "1"
        ];
        $data[ 'customer-support' ] = [
            "title" => "customer support",
            "identifier" => "customer-support",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/customerSupport.html'),
            "is_active" => "1"
        ];
        $data[ 'section-collapse' ] = [
            "title" => "section collapse",
            "identifier" => "section-collapse",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/sectionCollapse.html'),
            "is_active" => "1"
        ];
        $data[ 'agile-development' ] = [
            "title" => "agile development",
            "identifier" => "agile-development",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/agileDevelopment.html'),
            "is_active" => "1"
        ];
        $data[ 'integrations-content' ] = [
            "title" => "integrations content",
            "identifier" => "integrations-content",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/integrationsContent.html'),
            "is_active" => "1"
        ];
        $data[ 'container-heading-wlt' ] = [
            "title" => "container heading wlt",
            "identifier" => "container-heading-wlt",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/containerHeadingWlt.html'),
            "is_active" => "1"
        ];
        $data[ 'awesome-extensions' ] = [
            "title" => "awesome extensions",
            "identifier" => "awesome-extensions",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/awesomeExtensions.html'),
            "is_active" => "1"
        ];
        $data[ 'heading-title-awards' ] = [
            "title" => "heading title awards",
            "identifier" => "heading-title-awards",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/heading-title-awards.html'),
            "is_active" => "1"
        ];
        $data[ 'post-list' ] = [
            "title" => "post list",
            "identifier" => "post-list",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/postList.html'),
            "is_active" => "1"
        ];
        $data[ 'parter-Container' ] = [
            "title" => "parter Container",
            "identifier" => "parter-Container",
            "store_id" => "All Store Views",
            "content" => file_get_contents(__DIR__.'/html/parterContainer.html'),
            "is_active" => "1"
        ];

        foreach ( $data as $item) {

            $cmsBlockHome= $this->cmsBlock->create();

            $cmsBlockHome->addData($item);

            $this->cmsRepository->save($cmsBlockHome);

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
