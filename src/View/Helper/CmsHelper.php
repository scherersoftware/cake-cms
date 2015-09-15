<?php
namespace Cms\View\Helper;

use Cake\Filesystem\Folder;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;
use Cms\Model\Entity\CmsPage;
use Cms\Model\Entity\CmsRow;
use Cms\Widget\WidgetManager;

/**
 * Cms helper
 */
class CmsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = ['Html', 'FrontendBridge.FrontendBridge'];

    /**
     * Set by includeCmsAssets()
     *
     * @var bool
     */
    protected $_cmsAssetsIncluded = false;

    /**
     * Render a complete cms page
     *
     * @param CmsPage $page Page Entity
     * @return string Rendered Html
     */
    public function renderPage(CmsPage $page)
    {
        return $this->_View->element('Cms.CmsPages/main', [
            'page' => $page
        ]);
    }

    /**
     * Include necessary cms assets. This has to be called after the page has been rendered.
     * Best place is in the layout.
     *
     * @param array $options Options for the Html->script() calls
     * @return void|string
     */
    public function includeCmsAssets(array $options = [])
    {
        if ($this->_cmsAssetsIncluded) {
            return;
        }
        $options = Hash::merge([
            'block' => true
        ], $options);

        $out = '';
        $out .= $this->Html->scriptBlock('var Cms = {WidgetControllers: {}};', $options);

        $out .= $this->Html->script('Cms.app/lib/WidgetController.js', $options);

        $folder = new Folder();
        $controllers = [];
        $jsonData = [];
        foreach (WidgetManager::getRegistry() as $uniqueId => $widget) {
            $webrootPath = $widget->getWebrootPath();
            if (!is_dir($webrootPath)) {
                continue;
            }
            $jsonData[$uniqueId] = [
                'identifier' => $widget->getFullIdentifier(),
                'blockId' => $widget->getCmsBlock()->id,
                'jsonData' => $widget->getJsonData()
            ];

            $folder->cd($webrootPath . 'js/');
            $jsFiles = $folder->read();
            if (empty($jsFiles[1])) {
                continue;
            }
            foreach ($jsFiles[1] as $filename) {
                if (strpos($filename, 'WidgetController.js') !== false && strpos($filename, 'AdminWidgetController.js') === false) {
                    $controllers[] = '/cms/widget/' . $widget->getIdentifier() . '/js/' . $filename;
                }
            }
        }
        $this->FrontendBridge->setFrontendData('Cms', ['widgets' => $jsonData]);

        $out .= $this->Html->script($controllers, $options);
        $this->_cmsAssetsIncluded = true;
        if (!$options['block']) {
            return $out;
        }
    }

    /**
     * Render all blocks of a given row and column
     *
     * @param CmsRow $row Row Entity
     * @param int $column Numeric column index
     * @return string Rendered HTML
     */
    public function renderBlocksForColumnOfRow(CmsRow $row, $column)
    {
        return $this->_View->element('Cms.CmsRows/column', [
            'blocks' => $row->getBlocksForColumn($column)
        ]);
    }

    /**
     * Returns the column classes indexed by column index
     *
     * @param CmsRow $row Row Entity
     * @return array
     */
    public function getRowColumnLayout(CmsRow $row)
    {
        $columns = explode('-', $row->layout);
        $layout = [];
        foreach ($columns as $n => $columnWidth) {
            $columnIndex = ($n + 1);
            $layout[$columnIndex] = [
                'class' => 'col-md-' . $columnWidth
            ];
        }
        return $layout;
    }
}
