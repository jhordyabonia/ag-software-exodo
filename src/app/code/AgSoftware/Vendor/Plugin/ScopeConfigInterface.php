<?php
/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Vendor\Plugin;

class ScopeConfigInterface
{

    public function __construct( \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
                                \Magento\Customer\Model\CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
        $this->cartRepository = $cartRepository;
    }

    public function afterGetValue(
        \Magento\Framework\App\Config\ScopeConfigInterface $subject,
        $result,$key
    ) {

        $out = false;
        $key = $key?$key:"";
        $_key = explode('/',$key);
        if(count($_key) > 1){
            if($_key[0] == 'payment' && str_starts_with('mercadopago',$_key[1])){
                if(isset($_SESSION['checkout']['quote_id_1'])) {
                    $cart = $this->cartRepository->get($_SESSION['checkout']['quote_id_1']);
                    $cart->getItems()[0]->getProduct();
                    $vendorId = $cart->getItems()[0]->getProduct()->getData('agsoftware_vendor_id');
                    $customer = $this->customerFactory->create()->load($vendorId);
                    $vendor = null;
                    if($customer->getData('agsoftware_vendor')) {
                        $vendor = \json_decode($customer->getData('agsoftware_vendor'));
                    }
                    if($customer->getEmail() && $vendor != null ){
                        if( count($_key) > 2) {
                            if(isset($vendor->{$_key[0]}) && isset($vendor->{$_key[0]}->{$_key[1]})
                                && isset($vendor->{$_key[0]}->{$_key[1]}->{$_key[2]})) {
                                $out = $vendor->{$_key[0]}->{$_key[1]}->{$_key[2]};
                            }
                        }else {
                            if(isset($vendor->{$_key[0]}) && isset($vendor->{$_key[0]}->{$_key[1]})) {
                                $out = $vendor->{$_key[0]}->{$_key[1]};
                            }
                        }
                    }
                }
            }
        }
        if($out){
            file_put_contents(BP."/var/log/ag-software.log",$out." \n",FILE_APPEND);
            return $out;
        }
        return $result;
    }
}


