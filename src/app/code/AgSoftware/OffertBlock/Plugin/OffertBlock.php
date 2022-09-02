<?php

namespace AgSoftware\OffertBlock\Plugin;

class OffertBlock
{
    /**
     * @var \Magento\Cms\Api\Data\BlockInterfaceFactory
     */
    private $block;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $block,
        \Magento\Cms\Model\BlockRepository $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
        $this->block = $block;
    }

    function afterToHtml(\Magento\Cms\Block\Block $subject,$result){
        $cmsBlock = $this->block->create()->load($subject->getBlockId());
        if($cmsBlock->getIsOffert() && !empty($result)){
            $now = strtotime(date('m/d/Y H:i:s'));
            if(strtotime($cmsBlock->getOffertStartAt()) <= $now
                && strtotime($cmsBlock->getOffertEndAt()) >= $now ){
                $timmer = $subject->getLayout()
                    ->createBlock(\Magento\Framework\View\Element\Template::class)
                    ->setTemplate('AgSoftware_OffertBlock::timmer.phtml')
                    ->setOffertStartAt($cmsBlock->getOffertStartAt())
                    ->setOffertEndAt($cmsBlock->getOffertEndAt())
                    ->setOffertTimmerCss($cmsBlock->getOffertTimmerCss())
                    ->setOffertEndMessage($cmsBlock->getOffertEndMessage())
                    ->setOffertShowDays($cmsBlock->getOffertShowDays())
                    ->setIdentifier($cmsBlock->getIdentifier())
                    ->toHtml();
                return $timmer.$result;
            }elseif($cmsBlock->getOffertHiddenBlock()) {
                return "";
            }
        }
        return $result;
    }
}
