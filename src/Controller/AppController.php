<?php

namespace Cms\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Utility\Hash;

class AppController extends BaseController
{

    public $helpers = [
        'Cms.Cms',
        'Cms.CmsAdmin'
    ];

    protected $_adminAreaIntegration = true;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadComponent('Cms.Cms');
        parent::initialize();
    }

    /**
     * beforeRender Event
     *
     * @param Event $event Event
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if ($this->_adminAreaIntegration) {
            $this->_setupAdminAreaIntegration();
        }
        parent::beforeRender($event);
    }

    /**
     * Loads configured helpers and sets the layout for use in admin area
     *
     * @return void
     */
    protected function _setupAdminAreaIntegration()
    {
        // For good integration in existing administration areas, configure
        // View things here.
        if (method_exists($this, 'getView')) {
            // CakePHP 3.0.x
            $view = $this->getView();
            $view->layout = Configure::read('Cms.Administration.layout');
            foreach (Configure::read('Cms.Administration.helpers') as $helper) {
                $view->loadHelper($helper);
            }
        } else {
            // CakePHP 3.1.x
            $this->viewBuilder()->helpers(Configure::read('Cms.Administration.helpers'));
            $this->viewBuilder()->layout(Configure::read('Cms.Administration.layout'));
        }
    }
}
