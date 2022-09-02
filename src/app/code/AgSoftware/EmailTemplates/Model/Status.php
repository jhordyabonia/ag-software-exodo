<?php

namespace AgSoftware\EmailTemplates\Model;

use Magento\Framework\Webapi\Rest\Request as RestRequest;
use AgSoftware\EmailTemplates\Helper\Data as DataEmailTemplates;

class Status
{

    protected $_productsRepo;
    protected $_ordersRepo;
    protected $_request;

    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_orderRepository;
    protected $_addressRenderer;
    protected $_paymentHelper;
    /**
     * @var DataEmailTemplates
     */
    protected $dataEmailTemplates;
    /**
     * @var \Zend\Log\Logger
     */
    private $_logger;

    /**
     * @var string[]
     */
    protected $arrayStatusToPartials = array("enviado", "entregado");

    private $isPartial = false;

    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Sales\Api\Data\OrderInterface $orderRepository,
        \Magento\Sales\Model\Order\Address\Renderer $addressRenderer,
        \Magento\Payment\Helper\Data $paymentHelper,
        DataEmailTemplates $dataEmailTemplates,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \AgSoftware\EmailTemplates\Logger\Logger $logger
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->resourceConnection = $resourceConnection;
        $this->_transportBuilder = $transportBuilder;
        $this->_addressRenderer = $addressRenderer;
        $this->_scopeConfig = $scopeConfig;
        $this->_paymentHelper = $paymentHelper;
        $this->_logger = $logger;
        $this->dataEmailTemplates = $dataEmailTemplates;
    }



    public function getStorename()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getStoreEmail()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getTracking($incrementId,$test=false){
        $html = '{
            "data": {
                "delivery": {
                    "tracking_number": "7117'.random_int(900,999).'"
                }
            }
        }';
        if(!$test) {
            $html = file_get_contents("https://api.enviame.io/api/s2/v2/companies/mauiseller/deliveries/{$incrementId}/web-tracking");
        }
        return json_decode($html,true);
    }
    public function sendMail($templateId, $incrementId,$test=false)
    {
        $order = $this->_orderRepository->loadByIncrementId($incrementId);
        $this->_logger->info("templateId:========MI " . $templateId);
        //$this->isOrderPartial($order);
        if (!$order->getEntityId()) {
            $order = $this->_orderRepository->load($incrementId);
        }
        if (!$order->getEntityId()) {
            $this->_logger->info("Status: undefined order Id or incrementId: " .$incrementId);
            return false;
        }

        $message = $this->dataEmailTemplates->getMessagePrincipalByStatus($order->getStatus(), $order->getCustomerName());


        try {
            $this->_logger->info("Status: " . $order->getStatus() . " CustomerName: " . $order->getCustomerName());

            try{$trackingId = $this->getTracking($incrementId,$test)['data']['delivery']['tracking_number'];}
            catch (\Exception $e){
                $trackingId = 'No tracking Id';
            }
            $transportData = [
                'order' => $order,
                'tracking_id' => $trackingId ,
                'customer_name' => ucwords($order->getCustomerFirstname() . " " . $order->getCustomerLastname()),
                'billing' => $order->getBillingAddress(),
                'payment_html' => '',//$this->getPaymentHtml($order),
                'store' => $order->getStore(),
                'formattedShippingAddress' => '',// $this->getFormattedShippingAddress($order),
                'formattedBillingAddress' => '',//$this->getFormattedBillingAddress($order),
                'principal_message' => $message
            ];
            $sender = [
                "name" => $this->getStoreName(),
                "email" => $this->getStoreEmail()
            ];

            $this->_logger->info("MESSAGE: " . $message);
            $sendTo = [$order->getCustomerEmail()];
            $sendTo = array_merge($sendTo,$this->getBcc($order->getStoreId(),$order->getStatus()));
            foreach ($sendTo as $bcc){

                $this->_logger->info("sendTo: " . $bcc);
                $transport = $this->_transportBuilder
                    ->setTemplateIdentifier($templateId)
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => $order->getStoreId(),
                        ]
                    )
                    ->setTemplateVars($transportData)
                    ->setFrom($sender)
                    ->addTo($bcc);

                $transport->getTransport()->sendMessage();
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
            /*$this->_logger->info("Errorrrrrr al enviar email -> " . $th->getMessage());
            $this->_logger->info("Error al enviar email -> " . $th->getLine());
            $this->_logger->info("Error al enviar email -> " . $th->getFile());*/
            return false;
        }

    }
    public function getBcc($storeId,$status=null)
    {
        $keyConfig = '';
        if (str_replace('confirmado','', $status) != $status) {
            $keyConfig = 'sales_email/order_confirm/copy_to';
        } else if (str_replace('cancel','', $status) != $status) {
            $keyConfig = 'sales_email/order_canceled/copy_to';
        }

        $this->_logger->info("BCC: status " . $status);
        $this->_logger->info("BCC: keyConfig " . $keyConfig );
        if (!empty($keyConfig)) {
            $bcc = $this->_scopeConfig->getValue(
                $keyConfig,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                $storeId
            );
            $this->_logger->info("BCC: " . $bcc);
            return explode(",",trim($bcc));
        }
        return [];
    }


}
