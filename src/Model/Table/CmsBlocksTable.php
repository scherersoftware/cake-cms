<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cms\Model\Entity\CmsBlock;

/**
 * CmsBlocks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CmsRows
 */
class CmsBlocksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('cms_blocks');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('CkTools.Sortable', [
            'sortField' => 'position',
            'columnScope' => ['cms_row_id', 'column_index'],
            'defaultOrder' => ['position' => 'ASC']
        ]);
        $this->belongsTo('CmsRows', [
            'foreignKey' => 'cms_row_id',
            'className' => 'Cms.CmsRows'
        ]);

        $this->schema()->columnType('block_data', 'json');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'uuid'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->add('column_index', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('column');

        $validator
            ->requirePresence('widget', 'create')
            ->notEmpty('widget');

        $validator
            ->allowEmpty('data');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cms_row_id'], 'CmsRows'));
        return $rules;
    }

    /**
     * move a block
     *
     * @param CmsBlock $cmsBlock CMS Block Entity
     * @param string $rowId Row ID
     * @param string $columnIndex Column Index
     * @param string $position Position
     * @return void
     */
    public function moveBlock(CmsBlock $cmsBlock, $rowId, $columnIndex, $position)
    {
        $rowIdBefore = $cmsBlock->cms_row_id;
        $columnIndexBefore = $cmsBlock->column_index;

        $cmsBlock->column_index = $columnIndex;
        $cmsBlock->cms_row_id = $rowId;
        $cmsBlock->position = $position;
        $this->save($cmsBlock);
        $this->restoreSorting([
            'cms_row_id' => $rowId,
            'column_index' => $columnIndex
        ]);
        if ($rowId != $rowIdBefore || $columnIndex != $columnIndexBefore) {
            $this->restoreSorting([
                'cms_row_id' => $rowIdBefore,
                'column_index' => $columnIndexBefore
            ]);
        }
    }

    public function getPage(CmsBlock $cmsBlock, $field = null)
    {
        $block = $this->find()
            ->where([
                'CmsBlocks.id' => $cmsBlock->id
            ])
            ->contain([
                'CmsRows' => ['CmsPages']
            ])
            ->first();
        $cmsPage = $block->cms_row->cms_page;

        if (!empty($field) && !empty($cmsPage->$field)) {
            return $cmsPage->$field;
        }
        return $cmsPage;
    }
}
