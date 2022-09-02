<?php


namespace AgSoftware\StorePickup\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table = $setup->getConnection()->newTable($setup->getTable('agsoftware_storepickup'));

        
        $table->addColumn(
            'store_pickup_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table->addColumn(
            'country_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            2,
            [],
            'country_id'
        );
                
        $table->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            100,
            [],
            'name'
        );
        

        $table->addColumn(
            'active',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            ['default'=>1],
            'email'
        );
        

        $table->addColumn(
            'schedule',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'schedule'
        );
        

        $table->addColumn(
            'distrito',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'distrito'
        );
        

        
        $table->addColumn(
            'departamento',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            150,
            [],
            'departamento'
        );
        

        
        $table->addColumn(
            'provincia',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            150,
            [],
            'provincia'
        );
        

        
        $table->addColumn(
            'street',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            300,
            [],
            'street'
        );
        

        
        $table->addColumn(
            'telephone',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
            [],
            'telephone'
        );
        
        
        $table->addColumn(
            'postcode',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            [],
            'postcode'
        );
        

        
        $table->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            150,
            [],
            'email'
        );
        

        $table->addColumn(
            'stores',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            300,
           [],
           'Stores'
        );
            
        $table->addColumn(
            'extra',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            300,
           [],
           'Extra'
        );
            
        $table->addColumn(
            'price',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            20,
           ['default'=>'0','nullable' => false,'unsigned' => true],
           'price'
        );
              

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
