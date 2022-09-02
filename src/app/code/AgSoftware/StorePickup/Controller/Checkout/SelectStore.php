<?php
declare(strict_types=1);

namespace AgSoftware\StorePickup\Controller\Checkout;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;

//use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class SelectStore extends \Magento\Framework\App\Action\Action //implements CsrfAwareActionInterface
{

    protected $jsonResultFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Quote\Api\CartRepositoryInterface $carRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
    ) {
        $this->cartRepository = $cartRepository;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPostValue();
            $this->checkoutSession->setData('store_pickup',$post['store_pickup']);
            $result = $this->jsonResultFactory->create();
            $result->setData(true);
            return $result;
        }
        return $this->redirect('/');
    }
}

