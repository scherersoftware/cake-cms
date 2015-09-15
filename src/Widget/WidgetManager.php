<?php
namespace Cms\Widget;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cms\Model\Entity\CmsBlock;
use Cms\Widget\AbstractWidget;

class WidgetManager
{

    /**
     * Holds all widgets constructed in the current request
     *
     * @var array
     */
    protected static $_registry = [];

    /**
     * Returns an array with avilable widget identifiers
     *
     * @return array
     */
    public static function getAvailableWidgets()
    {
        $widgets = [];

        $config = Configure::read('Cms.Widgets.availableWidgets');
        if (is_array($config)) {
            return $config;
        }

        $namespace = Configure::read('App.namespace');

        $widgetPaths = App::path('Widget');
        foreach ($widgetPaths as $widgetPath) {
            $appWidgetsFolder = new Folder($widgetPath);
            $contents = $appWidgetsFolder->read(true);
            foreach ($contents[0] as $folderName) {
                $widgetIdentifier = "{$namespace}.{$folderName}";
                if (self::widgetExists($widgetIdentifier)) {
                    $widgets[] = $widgetIdentifier;
                }
            }
        }

        $plugins = Plugin::loaded();
        foreach ($plugins as $plugin) {
            $widgetsPath = Plugin::classPath($plugin) . 'Widget/';
            if (!is_dir($widgetsPath)) {
                continue;
            }
            $pluginWidgetsFolder = new Folder($widgetsPath);
            $contents = $pluginWidgetsFolder->read(true);
            foreach ($contents[0] as $folderName) {
                $widgetIdentifier = "{$plugin}.{$folderName}";
                if (self::widgetExists($widgetIdentifier)) {
                    $widgets[] = $widgetIdentifier;
                }
            }
        }

        $excludedWidgets = Configure::read('Cms.Widgets.excludedWidgets');
        $widgets = array_filter($widgets, function ($widgetIdentifier) use ($excludedWidgets) {
            return !in_array($widgetIdentifier, $excludedWidgets);
        });
        return $widgets;
    }

    /**
     * Adds a widget instance to the registry
     *
     * @param AbstractWidget $widget Widget Instance
     * @return void
     */
    public static function addToRegistry(AbstractWidget $widget)
    {
        $key = $widget->getUniqueId();
        self::$_registry[$key] = $widget;
    }

    /**
     * Returns the widget registry
     *
     * @return array
     */
    public static function getRegistry()
    {
        return self::$_registry;
    }

    /**
     * Returns an array, indexed by widget identifier with title and description
     * for the widgets
     *
     * @return array
     */
    public static function getWidgetList()
    {
        $availableWidgets = self::getAvailableWidgets();
        $widgetList = [];
        foreach ($availableWidgets as $widgetIdentifier) {
            $widget = WidgetFactory::identifierFactory($widgetIdentifier);
            $widgetList[$widgetIdentifier] = [
                'title' => $widget->config('title') ? $widget->config('title') : $widgetIdentifier,
                'description' => $widget->config('description')
            ];
        }
        return $widgetList;
    }

    /**
     * Checks if a widget with the given identifier exists
     *
     * @param string $widgetIdentifier E.g. "App.MyWidget", "MyPlugin.MyPluginWidget"
     * @return bool
     */
    public static function widgetExists($widgetIdentifier)
    {
        return class_exists(self::getWidgetClassName($widgetIdentifier));
    }

    /**
     * Returns the actual class name of a given widget identifier
     *
     * @param string $widgetIdentifier Widget Identifier
     * @return string Class Name
     */
    public static function getWidgetClassName($widgetIdentifier)
    {
        $className = '';
        list($plugin, $name) = pluginSplit($widgetIdentifier);
        
        $namespace = Configure::read('App.namespace');
        if (!empty($plugin)) {
            $namespace = $plugin;
        }
        $className = $namespace . '\\' . 'Widget\\' . $name . '\\' . $name . 'Widget';
        return $className;
    }
}
