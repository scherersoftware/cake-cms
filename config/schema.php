<?php
// @codingStandardsIgnoreStart
return [
	'tables' => [
        'cms_blocks' => [
            'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
            'cms_row_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'status' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'column_index' => ['type' => 'integer', 'length' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'position' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'widget' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'block_data' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            '_indexes' => [
                'fk_cms_blocks_cms_rows1_idx' => ['type' => 'index', 'columns' => ['cms_row_id'], 'length' => []],
            ],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
                'fk_cms_blocks_cms_rows1' => ['type' => 'foreign', 'columns' => ['cms_row_id'], 'references' => ['cms_rows', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
        'cms_pages' => [
            'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
            'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'status' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'system_relevant' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
            'page_attributes' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
        'cms_rows' => [
            'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
            'cms_page_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
            'layout' => ['type' => 'string', 'length' => 25, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
            'position' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            '_indexes' => [
                'fk_cms_rows_cms_pages1_idx' => ['type' => 'index', 'columns' => ['cms_page_id'], 'length' => []],
            ],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
                'fk_cms_rows_cms_pages1' => ['type' => 'foreign', 'columns' => ['cms_page_id'], 'references' => ['cms_pages', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
	]
];