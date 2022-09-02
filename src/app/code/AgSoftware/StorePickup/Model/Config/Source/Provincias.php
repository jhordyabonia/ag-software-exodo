<?php
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Provincias extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{


    /*public function __construct( \<Vendor>\<Module>\Model\ProvinciaFactory $provinciaFactory)
    {
        $this->_provinciaFactory = $provinciaFactory;
    }*/

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [['label'=>'Other', 'value'=>'']];

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
