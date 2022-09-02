<?php


namespace AgSoftware\StorePickup\Controller\Adminhtml\Storepickup;

class Delete extends \AgSoftware\StorePickup\Controller\Adminhtml\Storepickup
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('store_pickup_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('AgSoftware\StorePickup\Model\StorePickup');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Store Pickup.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['store_pickup_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Store Pickup to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * Check the permission to run it.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AgSoftware_StorePickup::store_pickup_delete');
    }

}
