<?php
/**
 * Copyright © none All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AgSoftware\Vendor\Controller\Sales;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Sales\Controller\Order\History
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    /*public function __construct(PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
    }*/

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    /*public function execute()
    {
        return $this->resultPageFactory->create();
    }*/
}

