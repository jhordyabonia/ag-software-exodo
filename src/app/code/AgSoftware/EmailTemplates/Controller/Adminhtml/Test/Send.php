<?php


namespace AgSoftware\EmailTemplates\Controller\Adminhtml\Test;

class Send extends  \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magento_Config::marketing';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \AgSoftware\EmailTemplates\Model\Status $status
        //\AgSoftware\EmailTemplates\Model\Status\History $historyRma,
        //\Magento\Rma\Model\Config $configRma,
        //\Magento\Rma\Model\RmaFactory $factoryRma
    ) {
        //$this->configRma = $configRma;
        //$this->rma = $factoryRma->create();
        //$this->historyrma = $historyRma;
        $this->status = $status;
        $this->dataPersistor = $dataPersistor;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    private function sendRma($increment_id){
       // $rma =$this->rma->load($increment_id);
       // return $this->historyrma->_sendRmaEmailWithItems($rma,$this->configRma->getRootRmaEmail()) ;
    }
    /**
     * New action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $incrementId = $this->getRequest()->getParam('increment_id');
        $templateId = $this->getRequest()->getParam('template_id');
        $entity = $this->getRequest()->getParam('entity');
        if($entity == 'rma'){
            //$this->sendRma($incrementId);
        }else {
            if (!$this->status->sendMail($templateId, $incrementId, true)) {
                $this->messageManager->addErrorMessage("No se envío el correo más detalles en '/var/log/ops_status.log'");
            } else {
                $this->messageManager->addSuccessMessage("Correo enviado.");
            }
        }
        $this->dataPersistor->set('increment_id',$incrementId);
        $this->dataPersistor->set('template_id',$templateId);
        $this->dataPersistor->set('entity',$entity);
        return $this->_redirect('email_template/test/');
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
