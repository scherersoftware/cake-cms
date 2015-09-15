<?php
namespace Cms\Widget;

use Cms\Model\Entity\CmsBlock;

class WidgetFactory
{

    /**
     * Construct an AbstractWidget instance using the given Block entity
     *
     * @param CmsBlock $block Block entity
     * @param array $config Instance Config
     * @param bool $addToRegistry Whether to add this to the WidgetManager registry.
     * @return Cms\Widget\AbstractWidget
     */
    public static function factory(CmsBlock $block, array $config = [], $addToRegistry = true)
    {
        $widgetClass = $block->getWidgetClassName();
        $widget = new $widgetClass($block->widget, $config, $block);
        if ($addToRegistry) {
            WidgetManager::addToRegistry($widget);
        }
        return $widget;
    }

    /**
     * Construct an AbstractWidget instance using only the widget identifier,
     * without a CmsBlock entity.
     *
     * @param string $widgetIdentifier Widget Identifier
     * @param array $config Optional Config
     * @return Cms\Widget\AbstractWidget
     */
    public static function identifierFactory($widgetIdentifier, array $config = [])
    {
        $widgetClass = WidgetManager::getWidgetClassName($widgetIdentifier);
        $widget = new $widgetClass($widgetIdentifier, $config, null);
        return $widget;
    }
}
