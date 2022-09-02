<?php

namespace AgSoftware\StorePickup\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getTable('agsoftware_storepickup');
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $installer->getConnection()->addColumn($table,'free',
                    [                            
                        'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,'comment' => '0 to ignore this field','length'=>20
                    ]
                );            
        }

        $installer->endSetup();
    }
}