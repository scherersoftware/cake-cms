<?php
namespace Cms\Widget;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\Core\Plugin;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventDispatcherTrait;
use Cake\Network\Request;
use Cake\Utility\Hash;
use Cake\View\View;
use Cake\View\ViewVarsTrait;
use Cms\Model\Entity\CmsBlock;

abstract class AbstractWidget
{

    use EventDispatcherTrait;
    use InstanceConfigTrait;
    use ModelAwareTrait;
    use ViewVarsTrait;

    /**
     * Request class. Necessary for ViewVarsTrait.
     *
     * @var \Cake\Network\Request
     */
    public $request;

    /**
     * Response class. Necessary for ViewVarsTrait.
     *
     * @var \Cake\Network\Response
     */
    public $response;

    /**
     * Contains the namespace. If the namespace corresponds to App.namespace, it
     * is contained directly in the application, otherwise this property equals the
     * plugin name.
     *
     * @var string
     */
    protected $_namespace;

    /**
     * If the Widget is contained in a plugin, this property will contain the Plugin name.
     * It is nulled if the widget is an app widget.
     *
     * @var string
     */
    protected $_plugin;

    /**
     * Contains the widget identifier.
     *
     * @var string
     */
    protected $_identifier;

    /**
     * Default configuration for InstanceConfigTrait
     *
     * @var array
     */
    protected $_defaultConfig = [
        'template' => 'main'
    ];

    /**
     * CmsBlock containing widget data
     *
     * @var Cms\Model\Entity\CmsBlock
     */
    protected $_block;

    /**
     * Holds data to be passed to the JS Controller
     *
     * @var array
     */
    protected $_jsonData;

    /**
     * Widget layout to use
     *
     * @var string
     */
    public $layout = 'Cms.CmsBlocks/default';

    /**
     * Constructor
     *
     * @param string $widgetIdentifier e.g. "Html", "MyPlugin.Wysiwyg"
     * @param array $config Configuration for the instance
     * @param CmsBlock $block CmsBlock Entity
     */
    public function __construct($widgetIdentifier, array $config = [], CmsBlock $block = null)
    {
        list($this->_namespace, $this->_identifier) = pluginSplit($widgetIdentifier);
        if ($this->_namespace != Configure::read('App.namespace')) {
            $this->_plugin = $this->_namespace;
        }
        $this->_block = $block;
        $this->set('block', $this->_block);
        $this->config($config);
        $this->_initialize();
    }

    /**
     * Initializer. Can be ovverridden by Widget classes.
     *
     * @return void
     */
    protected function _initialize()
    {
    }

    /**
     * Returns the full widget identifier, including Plugin, if present
     *
     * @return string
     */
    public function getFullIdentifier()
    {
        $prefix = '';
        if ($this->_namespace) {
            $prefix = $this->_namespace . '.';
        }
        return $prefix . $this->_identifier;
    }

    /**
     * Returns the widget's identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Pass data to the JS controller
     *
     * @param string|array $key Either a key, or an array
     * @param mixed $value Value
     * @return void
     */
    public function setJson($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setJson($k, $v);
            }
            return;
        }
        $this->_jsonData[$key] = $value;
    }

    /**
     * Returns the data set to JS controller
     *
     * @return array
     */
    public function getJsonData()
    {
        return $this->_jsonData;
    }

    /**
     * Returns the unique widget id. If the widget instance is based on a Block,
     * this will be the widget-identifier with the block ID (e.g. "Cms.Wysiwyg-23").
     * Otherwise a uniqid will be used instead.
     *
     * @return string
     */
    public function getUniqueId()
    {
        $id = $this->getFullIdentifier() . '-';
        if ($this->_block) {
            $id .= $this->_block->id;
        } else {
            $id .= uniqid();
        }
        return $id;
    }

    /**
     * Returns the descriptive title of the Widget or falls back to its identifier.
     *
     * @return string
     */
    public function getTitle()
    {
        return !empty($this->config('title')) ? $this->config('title') : $this->_identifier;
    }

    /**
     * Main action containing the logic for the widget. Shall be used for fetching data
     * and setting variables to the view.
     *
     * @param Request $request Request
     * @return void
     */
    abstract public function main(Request $request);

    /**
     * Will execute the main() method and render the view using the configured
     * template to use.
     *
     * @param Request $request Request
     * @return string Rendered HTML
     */
    public function render(Request $request, View $view = null)
    {
        $this->main($request);

        if (!$view) {
            $view = $this->getView();
        }

        $this->request = $request;

        return $view->element($this->layout, [
            'widget' => $this
        ]);
    }

    /**
     * Returns the cake-relative path to the template folder for this widget
     *
     * @return string
     */
    public function getViewFolderPath()
    {
        return ($this->_plugin ? $this->_plugin . '.' : '') . '../../Widget/' . $this->_identifier . '/Template/';
    }

    /**
     * Returns the absolute path to the Widget's base folder.
     *
     * @return string
     */
    public function getWidgetPath()
    {
        if ($this->_plugin) {
            $widgetPath = Plugin::classPath($this->_plugin) . 'Widget/';
        } else {
            $widgetPath = current(App::path('Widget'));
        }
        return $widgetPath . $this->_identifier . '/';
    }

    /**
     * Returns the absolute path to the Widget's webroot folder
     *
     * @return string
     */
    public function getWebrootPath()
    {
        return $this->getWidgetPath() . 'webroot/';
    }

    /**
     * Accessor to block data.
     * - blockData() returns the CmsBlock entity, if present
     * - blockData('path.to.var') returns the value of that Hash path
     * - blockData('path.to.var', 'nothing') returns the value of that Hash path if present, otherwise $default
     *
     * @param string $path Hash::get() conforming key path
     * @param mixed $default Default value
     * @return mixed
     */
    public function blockData($path = null, $default = null)
    {
        if (!$this->_block || !is_array($this->_block->block_data)) {
            return $default;
        }
        if (!$path) {
            return $this->_block;
        }
        return Hash::get($this->_block->block_data, $path, $default);
    }

    /**
     * Returns the CmsBlock instance this widget is based on
     *
     * @return CmsBlock
     */
    public function getCmsBlock()
    {
        return $this->_block;
    }

    /**
     * Gets the ID to use for the div in which this widget is rendered
     *
     * @return string
     */
    public function getDomId()
    {
        return str_replace('.', '-', $this->getUniqueId());
    }

    /**
     * Executed before rendering the admin preview of the widget. Can be used to set
     * view vars for the admin_preview template.
     *
     * @return void
     */
    public function adminPreview()
    {
    }

    /**
     * Executed before rendering the admin form of the widget. Can be used to set
     * view vars for the admin_form template.
     *
     * @return void
     */
    public function adminForm()
    {
    }
}
