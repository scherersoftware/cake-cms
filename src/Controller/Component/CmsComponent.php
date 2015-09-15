<?php
namespace Cms\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Cms component
 */
class CmsComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Fetch a CmsPage from the DB using its primary key
     *
     * @param string $id Primary key
     * @return CmsPage
     */
    public function getPage($id)
    {
        $CmsPagesTable = TableRegistry::get('Cms.CmsPages');
        return $CmsPagesTable->getPage($id);
    }
}
