<?php

namespace AgSoftware\StorePickup\Setup;

use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    public function __construct(
        CategorySetupFactory $categorySetupFactory,
        QuoteSetupFactory $quoteSetupFactory,
        SalesSetupFactory $salesSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        \Magento\Framework\App\ProductMetadata $productMetadata,
        \Magento\Framework\App\Config\Storage\WriterInterface $configStorageWriter
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->productMetadata = $productMetadata;
        $this->configStorageWriter = $configStorageWriter;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data =[
            '0'=> [
                ['CL','Primavera',1,1786,'14','192',' AV. AVIACION ESQ PRIMAVERA N° S/N (ANGAMOS ESTE 2681)',0,',komax_peru_storeview,sisi_peru_storeview,','15'],
            ],
        ];
        $columns = ['country_id','name','active','distrito','departamento','provincia','street','postcode','stores','price'];


        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->query('delete from agsoftware_storepickup where 1=1;');
            foreach ($data as $free=>$resources) {
                foreach ($resources as $resource) {
                    $bind=array_combine($columns,$resource);
                    $bind['schedule']='Lun - Dom<br/>10:00 am a 8:00 pm<br>El horario de atención del módulo Compra y Recoge es de 10am a 8pm de lunes a domingo, excepto por algún cambio o modificación que indique el gobierno';
                    $bind['free']=$free;
                    $setup->getConnection()->insert($setup->getTable('agsoftware_storepickup'), $bind);
                }
            }
        }
        $installer->endSetup();
    }
}
