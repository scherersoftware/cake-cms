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
     * Fetch a CmsPage from the DB using its primary key or by using the slug
     *
     * @param string $id Primary key
     * @param boolean $bySlug Slug
     * @return CmsPage
     */
    public function getPage($id, $bySlug = false)
    {
        $CmsPagesTable = TableRegistry::get('Cms.CmsPages');
        if ($bySlug) {
            $pageId = $CmsPagesTable->findPageIdBySlug($id);
        }
        if (isset($pageId)) {
            $id = $pageId;
        }
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
