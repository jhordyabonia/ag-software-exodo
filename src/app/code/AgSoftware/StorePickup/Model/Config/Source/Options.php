<?php 
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{ 

    /**
     * @var \AgSoftware\StorePickup\Model\StorePickupFactory
     */
    private $storePickupFactory;

    /**
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     */
    public function __construct(\AgSoftware\StorePickup\Model\StorePickupFactory $storePickupFactory)
    {
        $this->storePickupFactory = $storePickupFactory;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $customCollection = $this->storePickupFactory->create()->getCollection();
        $this->_options = [['label'=>'Please select', 'value'=>'']];
        foreach($customCollection as $custom)
        {
            $this->_options[] = ['label'=> $custom->getName(), 'value' => $custom->getStoreCode()];
        }
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}