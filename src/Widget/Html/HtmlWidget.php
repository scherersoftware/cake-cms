<?php
namespace Cms\Widget\Html;

use Cake\Network\Request;
use Cms\Widget\AbstractWidget;

class HtmlWidget extends AbstractWidget
{

    /**
     * Initializer
     *
     * @return void
     */
    protected function _initialize()
    {
        $this->config('title', 'HTML');
        $this->config('description', 'Plain HTML');
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
