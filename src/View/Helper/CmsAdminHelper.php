<?php
namespace Cms\View\Helper;

use Cake\Filesystem\Folder;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;
use Cms\Model\Entity\CmsBlock;
use Cms\Model\Entity\CmsPage;
use Cms\Model\Entity\CmsRow;
use Cms\Widget\WidgetFactory;
use Cms\Widget\WidgetManager;

/**
 * Cms helper
 */
class CmsAdminHelper extends Helper
{

    public $helpers = ['Html', 'Form'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Includes all necessary JS code for admin editing of CmsBlocks.
     *
     * @return void
     */
    public function includeCmsAdminAssets()
    {
        $script = 'var Cms = {AdminWidgetControllers: {}};';
        $this->Html->scriptBlock($script, ['block' => true]);

        $this->Html->script('Cms.app/lib/AdminWidgetController.js', ['block' => true]);

        $availableWidgets = WidgetManager::getAvailableWidgets();
        $adminControllers = [];
        $folder = new Folder();
        foreach ($availableWidgets as $widgetIdentifier) {
            $widget = WidgetFactory::identifierFactory($widgetIdentifier);
            $webrootPath = $widget->getWebrootPath();
            if (!is_dir($webrootPath)) {
                continue;
            }
            $folder->cd($webrootPath . 'js/');
            $jsFiles = $folder->read();

            if (empty($jsFiles[1])) {
                continue;
            }
            foreach ($jsFiles[1] as $filename) {
                if (strpos($filename, 'AdminWidgetController.js') !== false) {
                    $adminControllers[] = '/cms/widget/' . $widgetIdentifier . '/js/' . $filename;
                }
            }
        }
        $this->Html->script($adminControllers, ['block' => true]);
    }

    /**
     * Render the admin preview of a block
     *
     * @param CmsBlock $block Block Entity
     * @return string Rendered HTML
     */
    public function renderBlockAdminPreview(CmsBlock $block)
    {
        $widget = WidgetFactory::factory($block);
        $widget->adminPreview();
        $previewElement = 'Cms.Design/default_admin_preview';
        if ($this->_View->elementExists($widget->getViewFolderPath() . 'admin_preview')) {
            $previewElement = $widget->getViewFolderPath() . 'admin_preview';
        }
        return $this->_View->element('Cms.Design/block_panel', [
            'previewElement' => $previewElement,
            'widget' => $widget,
            'block' => $block
        ]);
    }

    /**
     * Render the admin form of a widget, if present.
     *
     * @param CmsBlock $block Block Entity
     * @return string Rendered HTML
     */
    public function renderBlockAdminForm(CmsBlock $block)
    {
        $widget = WidgetFactory::factory($block);
        $widget->adminForm();
        $adminFormElement = 'Cms.Design/default_admin_form';
        if ($this->_View->elementExists($widget->getViewFolderPath() . 'admin_form')) {
            $adminFormElement = $widget->getViewFolderPath() . 'admin_form';
        }
        $viewVars = Hash::merge([
            'widget' => $widget,
            'block' => $block
        ], $widget->viewVars);
        return $this->_View->element($adminFormElement, $viewVars);
    }

    /**
     * Renders an input for a given Page Attribute
     *
     * @param string $attribute Attribute name
     * @param array $attributeConfig Attribute Configuration
     * @return string Rendered HTML
     */
    public function renderPageAttributeInput($attribute, array $attributeConfig)
    {
        $options = [
            'label' => $attributeConfig['label']
        ];

        $value = $attributeConfig['value'];
        $label = $attributeConfig['label'];
        $type = 'text';

        switch ($attributeConfig['type']) {
            case 'boolean':
                $type = 'checkbox';
                $value = 1;
                $options['checked'] = $attributeConfig['value'];
                break;
        }

        $options['type'] = $type;
        $options['value'] = $value;
        $options['label'] = $label;

        return $this->Form->input('page_attributes.' . $attribute, $options);
    }
}
