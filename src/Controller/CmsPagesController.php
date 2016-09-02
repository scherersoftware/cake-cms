<?php
namespace Cms\Controller;

use App\Lib\Status;
use Cake\Core\Configure;
use Cake\Utility\Hash;

class CmsPagesController extends AppController
{

    public $paginate = [
        'limit' => 50,
        'order' => ['CmsPages.name' => 'ASC']
    ];

    /**
     * Provides ListFilter configuration
     *
     * @return array
     */
    public function getListFilters()
    {
        $filters = [];
        if ($this->request->action == 'index') {
            $filters['fields'] = [
                'CmsPages.fulltext_search' => [
                    'searchType' => 'fulltext',
                    'searchFields' => [
                        'CmsPages.name',
                        'CmsPages.slug'
                    ]
                ]
            ];
        }
        return $filters;
    }

    /**
     * List CMS Pages
     *
     * @return void
     */
    public function index()
    {
        $cmsPages = $this->paginate($this->CmsPages);
        $previewUrl = Configure::read('Cms.Frontend.renderAction');
        $this->set(compact('cmsPages', 'previewUrl'));
    }

    /**
     * Add a CMS page
     *
     * @return void
     */
    public function add()
    {
        $cmsPage = $this->CmsPages->newEntity();
        if ($this->request->is('post')) {
            $cmsPage = $this->CmsPages->patchEntity($cmsPage, $this->request->data);
            $cmsPage->status = Status::ACTIVE;
            if ($this->CmsPages->save($cmsPage)) {
                $this->Flash->success(__('forms.data_saved'));
                return $this->redirect(['action' => 'edit', $cmsPage->id]);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->set(compact('cmsPage'));
    }

    /**
     * Edit a CMS page
     *
     * @return void
     */
    public function edit($id = null)
    {
        $cmsPage = $this->CmsPages->getPage($id);
        $previewUrl = Configure::read('Cms.Frontend.renderAction');
        $previewUrl[] = $id;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cmsPage = $this->CmsPages->patchEntity($cmsPage, $this->request->data);
            if ($this->CmsPages->save($cmsPage)) {
                $this->Flash->success(__('forms.data_saved'));
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->FrontendBridge->setJson('confirmMessage', __d('cms', 'cms_pages.design.really_delete_block'));
        $this->FrontendBridge->setJson('pageId', $cmsPage->id);
        $this->set(compact('cmsPage', 'previewUrl'));
    }

    /**
     * Used for rendering the page in the frontend
     *
     * @param string $pageId Page ID
     * @return void
     */
    public function show($pageId = null)
    {
        $page = $this->Cms->getPage($pageId);
        $this->set(compact('page'));
        $this->_adminAreaIntegration = false;
    }
}
