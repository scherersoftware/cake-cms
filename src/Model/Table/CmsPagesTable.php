<?php
namespace Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cms\Model\Entity\CmsPage;

/**
 * CmsPages Model
 *
 * @property \Cake\ORM\Association\HasMany $CmsRows
 */
class CmsPagesTable extends Table
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

        $this->table('cms_pages');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('CmsRows', [
            'foreignKey' => 'cms_page_id',
            'className' => 'Cms.CmsRows'
        ]);

        $this->schema()->columnType('page_attributes', 'json');
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
            ->requirePresence('slug', 'create')
            ->notEmpty('slug', __d('cms', 'validation.not_empty'))
            ->add('slug', 'custom_characters', [
                'rule' => ['custom', '/^[^\/]([a-z0-9\-_\/]+)$/i'],
                'message' => __d('cms', 'cms_page.validation.slug_allowed_characters')
            ]);

        $validator
            ->add('slug', 'custom_double_slash', [
                'rule' => function ($value, $context) {
                    return strpos($value, '//') === false;
                },
                'message' => __d('cms', 'cms_page.validation.slug_double_slash')
            ]);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', __d('cms', 'validation.not_empty'));

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('system_relevant');

        return $validator;
    }

    /**
     * buildRules
     *
     * @param RulesChecker $rules Rules Checker
     * @return void
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['slug']));
        return $rules;
    }

    /**
     * Fetch a page including all necessary entities
     *
     * @param string $pageId Primary key
     * @return CmsPage
     */
    public function getPage($pageId)
    {
        return $this->get($pageId, [
            'contain' => [
                'CmsRows' => [
                    'sort' => ['CmsRows.position' => 'ASC'],
                    'CmsBlocks' => [
                        'sort' => ['CmsBlocks.position' => 'ASC']
                    ]
                ]
            ]
        ]);
    }

    /**
     * Tries to find a page's id based on its slug. Used by the SlugRoute class.
     *
     * @param string $slug URL, can have trailing slashes
     * @return string|false
     */
    public function findPageIdBySlug($slug)
    {
        // strip leading / if present
        $slug = ltrim($slug, '/');
        $result = $this->find()
            ->select('id')
            ->where([
                'slug' => $slug
            ])
            ->hydrate(false)
            ->first();
        if (!empty($result)) {
            return $result['id'];
        }
        return false;
    }
}
