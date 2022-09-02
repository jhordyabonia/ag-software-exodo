<?php

namespace AgSoftware\EmailTemplates\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Throwable;

class Data extends AbstractHelper
{
    const MESSAGE_STATUS_PEDIDO_CONFIRMADO = 'sales_email/messages_ops_status/message_order_confirm';
    const MESSAGE_STATUS_PEDIDO_CONFIRMADO_PARCIAL = 'sales_email/messages_ops_status/message_order_confirm_partial';
    const MESSAGE_STATUS_ENVIADO = 'sales_email/messages_ops_status/message_order_sended';
    const MESSAGE_STATUS_ENVIADO_PARCIAL = 'sales_email/messages_ops_status/message_order_sended_partial';
    const MESSAGE_STATUS_ENTREGADO = 'sales_email/messages_ops_status/message_order_delivered';
    const MESSAGE_STATUS_ENTREGADO_PARCIAL = 'sales_email/messages_ops_status/message_order_delivered_partial';


    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }


    /**
     * @param string $path
     * @return mixed
     */
    public function getConfig(string $path)
    {
        // $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        // $scopeCode = null;
        $storeScope = ScopeInterface::SCOPE_STORES;

        return $this->scopeConfig->getValue($path, $storeScope);
    }

    public function getMessagePrincipalByStatus($status, $name_customer)
    {


        try {
            $_mconfig = constant('self::MESSAGE_STATUS_' . strtoupper($status));
            $message = $this->getConfig($_mconfig);
            $message = str_replace("%name%", $name_customer, $message);
        } catch (Throwable $e) {
           $message ="";
        }

        return $message;


    }
}
