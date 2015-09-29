<?php
namespace Cms\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Exception\UnauthorizedException;
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
    protected $_defaultConfig = [
        'permissionsCallback' => null
    ];

    /**
     * Fetch a CmsPage from the DB using its primary key
     *
     * @param string $id Primary key
     * @return CmsPage
     */
    public function getPage($id)
    {
        $CmsPagesTable = TableRegistry::get('Cms.CmsPages');
        $page = $CmsPagesTable->getPage($id);
        $callback = $this->config('permissionsCallback');
        if ($callback && is_callable($callback)) {
            if (!$callback($page)) {
                throw new UnauthorizedException();
            }
        }
        return $page;
    }
}
