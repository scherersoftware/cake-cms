<?php
namespace Cms\Widget\Image;

use Cake\Core\Configure;
use Cake\Network\Request;
use Cms\Widget\AbstractWidget;

class ImageWidget extends AbstractWidget
{

    protected $_layouts = [
        'default' => 'Default',
        'circle' => 'Circle'
    ];

    /**
     * Initializer
     *
     * @return void
     */
    protected function _initialize()
    {
        $this->config('title', 'Image');
        $this->config('description', 'Image Widget');
    }

    /**
     * Main Action
     *
     * @param Request $request Request
     * @return void
     */
    public function main(Request $request)
    {
        $this->set('imagePath', $this->blockData('image_path'));
        $this->config('template', 'layout_' . $this->blockData('layout'));
    }

    /**
     * Admin Form
     *
     * @return void
     */
    public function adminForm()
    {
        $layouts = $this->_layouts;
        $this->set(compact('layouts'));
    }

    /**
     * Admin Preview
     *
     * @return void
     */
    public function adminPreview()
    {
        $this->set('imagePath', $this->blockData('image_path'));
    }
}
