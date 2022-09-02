<?php


namespace AgSoftware\StorePickup\Controller\Adminhtml\Storepickup;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('store_pickup_id');

            $model = $this->_objectManager->create('AgSoftware\StorePickup\Model\StorePickup')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Store Pickup no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data['stores'] = implode(',',$data['stores']);
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Store Pickup.'));
                $this->dataPersistor->clear('agsoftware_storepickup_store_pickup');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['store_pickup_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Store Pickup.'));
            }

            $this->dataPersistor->set('agsoftware_storepickup_store_pickup', $data);
            return $resultRedirect->setPath('*/*/edit', ['store_pickup_id' => $this->getRequest()->getParam('store_pickup_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * Check the permission to run it.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AgSoftware_StorePickup::store_pickup_save');
    }

}
