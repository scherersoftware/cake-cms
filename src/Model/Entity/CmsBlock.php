<?php
namespace Cms\Model\Entity;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\ORM\Entity;
use Cake\View\View;
use Cms\Widget\WidgetFactory;
use Cms\Widget\WidgetManager;

/**
 * CmsBlock Entity.
 */
class CmsBlock extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Render the block
     *
     * @param Request $request Request
     * @param View $view Optional View Instance for rendering.
     * @return string Rendered HTML
     */
    public function render(Request $request, View $view = null)
    {
        $widget = WidgetFactory::factory($this);
        return $widget->render($request, $view);
    }

    /**
     * Returns the class name for the widget to use for this block
     *
     * @return string
     */
    public function getWidgetClassName()
    {
        return WidgetManager::getWidgetClassName($this->widget);
    }
}
