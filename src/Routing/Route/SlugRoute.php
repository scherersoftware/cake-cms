<?php
namespace Cms\Routing\Route;

use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Utility\Hash;

class SlugRoute extends Route
{

    /**
     * Parses an URL and tries to match
     *
     * @param string $url URL
     * @return array|false
     */
    public function parse($url)
    {
        $PagesModel = TableRegistry::get('Cms.CmsPages');
        if ($pageId = $PagesModel->findPageIdBySlug($url)) {
            $url = Hash::merge($this->defaults, [
                'pass' => [$pageId]
            ]);
            return $url;
        }
        return false;
    }
}
