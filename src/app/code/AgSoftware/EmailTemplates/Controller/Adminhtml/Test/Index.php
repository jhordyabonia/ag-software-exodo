<?php


namespace AgSoftware\EmailTemplates\Controller\Adminhtml\Test;

class Index extends  \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magento_Config::marketing';
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * New action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('AgSoftware'), __('AgSoftware'))
            ->addBreadcrumb(__('EmailTemplates'), __('EmailTemplates'));
        return $resultPage;
    }


    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
