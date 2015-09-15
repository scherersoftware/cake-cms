<?php
use Migrations\AbstractMigration;

class Cms extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cms_blocks', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cms_row_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('column_index', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('position', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => true,
            ])
            ->addColumn('widget', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('block_data', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cms_row_id',
                ]
            )
            ->create();

        $table = $this->table('cms_pages', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 30,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $table = $this->table('cms_rows', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cms_page_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('layout', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('position', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cms_page_id',
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->table('cms_blocks')
            ->dropForeignKey(
                'cms_row_id'
            )
            ->update();

        $this->table('cms_rows')
            ->dropForeignKey(
                'cms_page_id'
            )
            ->update();

        $this->dropTable('cms_blocks');
        $this->dropTable('cms_pages');
        $this->dropTable('cms_rows');
    }
}
