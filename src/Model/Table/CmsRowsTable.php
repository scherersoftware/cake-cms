<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cms\Model\Entity\CmsRow;

/**
 * CmsRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CmsPages
 * @property \Cake\ORM\Association\HasMany $CmsBlocks
 */
class CmsRowsTable extends Table
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

        $this->table('cms_rows');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('CkTools.Sortable', [
            'sortField' => 'position',
            'columnScope' => ['cms_page_id'],
            'defaultOrder' => ['position' => 'ASC']
        ]);
        $this->belongsTo('CmsPages', [
            'foreignKey' => 'cms_page_id',
            'joinType' => 'INNER',
            'className' => 'Cms.CmsPages'
        ]);
        $this->hasMany('CmsBlocks', [
            'foreignKey' => 'cms_row_id',
            'className' => 'Cms.CmsBlocks',
            'dependent' => true
        ]);

        if (Configure::read('Cms.Administration.useModelHistory')) {
            $this->addBehavior('ModelHistory.Historizable', [
                'userNameFields' => [
                    'firstname' => 'forename',
                    'lastname' => 'surname',
                    'id' => 'Users.id'
                ]
            ]);
        }
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
            ->requirePresence('layout', 'create')
            ->notEmpty('layout');

        $validator
            ->add('position', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('position');

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
        $rules->add($rules->existsIn(['cms_page_id'], 'CmsPages'));
        return $rules;
    }

    /**
     * move a row
     *
     * @param CmsRow $cmsRow CMS Row Entity
     * @param string $position Position
     * @return void
     */
    public function moveRow(CmsRow $cmsRow, $position)
    {
        dlog('new row position: ' . $position);
        $cmsRow->position = $position;
        $this->save($cmsRow);
        $this->restoreSorting([
            'cms_page_id' => $cmsRow->cms_page_id
        ]);
    }
}
