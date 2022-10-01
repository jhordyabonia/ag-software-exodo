<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AgSoftware\Vendor\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Store\Model\Store;
use Magento\Store\Model\ScopeInterface;
use Magento\Sales\Api\PaymentFailuresInterface;

/**
 * Checkout default helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    private CustomerRepositoryInterface $customerRepository;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * Retrieve checkout session model
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getCustomerName($customerId){
        $customer = $this->customerRepository->getById($customerId);
        return $customer->getFirstName()." ".$customer->getLastName();
    }
}
