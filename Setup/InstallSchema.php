<?php
//delete from setup_module where module='Swissup_Tfa';
namespace Swissup\Tfa\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('swissup_tfa'))
            ->addColumn('id', Table::TYPE_INTEGER, 11, [
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ], 'Id')
            ->addColumn(
                'user_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'User ID'
            )->addColumn(
                'is_active',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true, 'default' => 0],
                'Is require TFA for Login'
            )
            ->addColumn(
                'secret',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Secret Key'
            )
            ->addColumn('created', Table::TYPE_DATETIME, null, [
                'nullable'  => true,
                'default'  => null,
            ], 'Created')
            ->addColumn('updated', Table::TYPE_DATETIME, null, [
                'nullable'  => true,
                'default'  => null,
            ], 'Updated')
            ->addForeignKey(
                $installer->getFkName('swissup_tfa', 'user_id', 'admin_user', 'user_id'),
                'user_id',
                $installer->getTable('admin_user'),
                'user_id',
                Table::ACTION_CASCADE
            )
            ;
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
