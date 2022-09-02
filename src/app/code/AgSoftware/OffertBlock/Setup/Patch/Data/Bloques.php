<?php

namespace AgSoftware\OffertBlock\Setup\Patch\Data;

class Bloques implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * CreateHeaderBlock constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Model\BlockRepository $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterface $block
     */

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Model\BlockRepository $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $block,
        \Magento\Cms\Api\GetBlockByIdentifierInterface $blockByIdentifier
    ) {
        $this->blockRepository = $blockRepository;
        $this->block = $block;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockByIdentifier = $blockByIdentifier;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $block_data=[
            [
                'title' => 'Offert Block 1',
                'identifier' => 'offert-block-1',
                'is_active' => 1,
                'is_offert' => 1,
                'offert_end_message' => 'La oferta terminó',
                'offert_end_at'=> '12/31/2022',
                'offert_timmer_css' => file_get_contents(__DIR__.'/html/offert-block-1.css'),
                'content' => file_get_contents(__DIR__.'/html/offert-block-1.html'),
            ],
        ];
        foreach ($block_data as $block) {
            $this->makeBackup($block);
            $block_head = $this->block->create();
            $block_head->addData($block);
            $block_head->setStores([0]);
            $this->blockRepository->save($block_head);
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function makeBackup($data){
        $block = $this->block->create()->load($data['identifier'],'identifier');
        if($block->getId()>0){
            $backup = $this->block->create()->load($data['identifier'].'-backup','identifier');
            if($backup->getId()>0){
                $backup->delete();
            }
            $block->setIdentifier($data['identifier'].'-backup')->setActive(0)->save();
        }
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
    /**
     * Revert patch
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        //code
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
