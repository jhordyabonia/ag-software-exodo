<?php
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Countries extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var \Magento\Directory\Model\CountryFactory
     */
    private $countryFactory;

    /**
     * @param \Magento\Directory\Model\CountryFactory $countryFactory
     */
    public function __construct(\Magento\Directory\Model\CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $customCollection = $this->countryFactory->create()->getCollection();
        $this->_options = [['label'=>'Please select', 'value'=>'']];
        foreach($customCollection as $custom)
        {
            $this->_options[] = ['label'=> $custom->getName(), 'value' => $custom->getId()];
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
