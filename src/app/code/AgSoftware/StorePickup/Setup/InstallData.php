<?php
namespace AgSoftware\StorePickup\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Quote\Setup\QuoteSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $data = [
            [1,'PE','Primavera',1,'Lun - Dom<br/>10:00 am a 8:00 pm',1786,'14','192',' AV. AVIACION ESQ PRIMAVERA N° S/N (ANGAMOS ESTE 2681)','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'15'],
            [2,'PE','Salaverry',1,'Lun - Dom<br/>10:00 am a 8:00 pm',1777,'14','192','AV. GENERAL FELIPE SALAVERRY N° 2370','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'15'],
            [3,'PE','Puruchuco',1,'Lun - Dom<br/>10:00 am a 8:00 pm',1769,'14','192','PROLONGACION JAVIER PRADO 8680.','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'15'],
            [4,'PE','Piura',1,'Lun - Dom<br/>10:00 am a 8:00 pm',1448,'19','150','AV. SANCHEZ CERRO N° 234','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'20'],
            [5,'PE','Arequipa',1,'Lun - Dom<br/>10:00 am a 8:00 pm',331,'4','35',' AV. EL EJERCITO N° 1009. CAYMA. AREQUIPA','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'20'],
            [6,'PE','Trujillo',1,'Lun - Dom<br/>10:00 am a 8:00 pm',1127,'12','112','AV. CESAR VALLEJO OESTE N° 1345.','975782076',0,'info@komax.com.pe',',andesgear_peru_store_view,andesgear_store_view,banana_peru_store_view,brooks_brothers_store_view,gap_peru_store_view,kipling_peru_store_view,komax_peru_storeview,sisi_peru_storeview,tnfperu_store_view',NULL,'20']
          ];
        $columns = ['store_pickup_id','country_id','name','active','schedule','distrito','departamento','provincia','street','telephone','postcode','email','stores','extra','price'];

        foreach ($data as $resource) {
            $bind = [];
            foreach($resource as $key=>$column){
                $bind[$columns[$key]] = $column;
            }
            $setup->getConnection()->insert($setup->getTable('agsoftware_storepickup'), $bind);
        }
        
        $setup->endSetup();
    }

}
