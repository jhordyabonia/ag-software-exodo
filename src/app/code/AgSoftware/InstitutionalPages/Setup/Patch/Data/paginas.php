<?php

namespace AgSoftware\InstitutionalPages\Setup\Patch\Data;

class Paginas implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * CreateHeaderpage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Model\pageRepository $pageRepository
     * @param \Magento\Cms\Api\Data\pageInterface $page
     */

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Model\PageRepository $pageRepository,
        \Magento\Cms\Api\Data\PageInterfaceFactory $page,
        \Magento\Cms\Api\GetPageByIdentifierInterface $pageByIdentifier
    ) {
        $this->pageRepository = $pageRepository;
        $this->page = $page;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageByIdentifier = $pageByIdentifier;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        //code

        $page_data = [];

        $page_data['legacy-notice'] = [
            'content_heading'=>'',
            'title' => 'Legacy Notice',
            'identifier' => 'legacy-notice',
            'page_layout' => 'empty',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/legal-notice.html'),

        ];

        $page_data['about-us'] = [
            'content_heading'=>'',
            'title' => 'About Us',
            'identifier' => 'about-us',
            'page_layout' => 'empty',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/about-us.html'),

        ];

        $page_data['privacy-policy'] = [
            'content_heading'=>'',
            'title' => 'Privacy Policy',
            'identifier' => 'privacy-policy',
            'page_layout' => 'empty',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/privacy-policy.html'),

        ];

        $page_data['contact-us'] = [
            'content_heading'=>'',
            'title' => 'contact us',
            'identifier' => 'contact-us',
            'page_layout' => 'empty',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/contact-us.html'),

        ];

        $page_data['term-and-conditions'] = [
            'content_heading'=>'',
            'title' => 'term and conditions',
            'identifier' => 'term-and-conditions',
            'page_layout' => 'empty',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/term-and-conditions.html'),

        ];


        foreach ( $page_data as $item) {

            $Institutionalpage = $this->page->create();

            $Institutionalpage->addData($item);

            $this->pageRepository->save($Institutionalpage);

        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

}
