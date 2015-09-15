<?php
namespace Cms\Widget\Divider;

use Cake\Network\Request;
use Cms\Widget\AbstractWidget;

class DividerWidget extends AbstractWidget
{

    /**
     * Initializer
     *
     * @return void
     */
    protected function _initialize()
    {
        $this->config('title', 'Divider');
        $this->config('description', 'Divider Widget');
    }

    /**
     * Main Action
     *
     * @param Request $request Request
     * @return void
     */
    public function main(Request $request)
    {
    }
}
