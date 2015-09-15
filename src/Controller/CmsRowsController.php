<?php
namespace Cms\Controller;

use Cms\Widget\WidgetFactory;
use FrontendBridge\Lib\ServiceResponse;

class CmsRowsController extends AppController
{

    /**
     * Add a row to the given page
     *
     * @param string $pageId Page ID
     * @return void
     */
    public function add($pageId = null)
    {
        $cmsPage = $this->CmsRows->CmsPages->getPage($pageId);

        $cmsRow = $this->CmsRows->newEntity();
        if ($this->request->is('post')) {
            $cmsRow = $this->CmsRows->patchEntity($cmsRow, $this->request->data);
            $cmsRow->cms_page_id = $pageId;
            if ($this->CmsRows->save($cmsRow)) {
                $this->FrontendBridge->setJson('success', true);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->set(compact('cmsRow'));
    }

    /**
     * Delete a row
     *
     * @param string $id Row ID
     * @return ServiceResponse
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
        try {
            $cmsRow = $this->CmsRows->get($id);
            $this->CmsRows->delete($cmsRow);
        } catch (\Exception $e) {
        }
        return new ServiceResponse('success');
    }

    /**
     * move a row
     *
     * @param string $id Row ID
     * @return ServiceResponse
     */
    public function move($id = null)
    {
        $this->request->allowMethod('post');
        $position = $this->request->data('position') + 1;
        try {
            $cmsRow = $this->CmsRows->get($id);
            $this->CmsRows->moveRow($cmsRow, $position);
        } catch (\Exception $e) {
        }
        return new ServiceResponse('success');
    }
}
