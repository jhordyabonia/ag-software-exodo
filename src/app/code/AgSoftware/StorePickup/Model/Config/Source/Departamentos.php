<?php
namespace AgSoftware\StorePickup\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\DB\Ddl\Table;

class Departamentos extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function __construct(
        DataPersistorInterface $dataPersistor,
        \Magento\Directory\Model\ResourceModel\Region\Collection $region){
        $this->dataPersistor = $dataPersistor;
        $this->region = $region;
    }
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $out = [['label'=>'Please select', 'value'=>'']];
        $countryId = $this->dataPersistor->get(\AgSoftware\StorePickup\Controller\Adminhtml\Storepickup\Data::COUNTRYID);
        if(!$countryId) {
            return $out;
        }
        $this->region->addFieldToFilter('country_id', ['eq' => $countryId]);
        /**
         * @var \Magento\Directory\Model\Region $region
         */
        foreach ($this->region->load() as $key => $region){
            $out [$key] = ["label"=>$region->getName(),"value"=>$region->getId()];
        }
        return $out;
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
