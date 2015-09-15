<?php
namespace Cms\Widget\TinyMce;

use Cake\Network\Request;
use Cms\Widget\AbstractWidget;

class TinyMceWidget extends AbstractWidget
{

    /**
     * Initializer
     *
     * @return void
     */
    protected function _initialize()
    {
        $this->config('title', 'WYSIWYG');
        $this->config('description', 'TinyMCE Editor');
    }

    /**
     * Main Action
     *
     * @param Request $request Request
     * @return void
     */
    public function main(Request $request)
    {
        $this->set('html', $this->blockData('html'));
    }
}
