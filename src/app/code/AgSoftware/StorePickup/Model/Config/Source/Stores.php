<?php 
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Stores extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{ 

    /**
     * @var \Magento\Store\Model\StoreFactory 
     */
    private $storeFactory;

    /**
     * @param \Magento\Store\Model\StoreFactory $storeFactory
     */
    public function __construct(\Magento\Store\Model\StoreFactory $storeFactory)
    {
        $this->storeFactory = $storeFactory;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $customCollection = $this->storeFactory->create()->getCollection();
        $this->_options = [['label'=>'Please select', 'value'=>'']];
        foreach($customCollection as $custom)
        {
            $this->_options[] = ['label'=> $custom->getName(), 'value' => $custom->getCode()];
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