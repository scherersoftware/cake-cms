<?php
namespace Cms\Controller;

use Cms\Widget\WidgetFactory;
use Cms\Widget\WidgetManager;
use FrontendBridge\Lib\ServiceResponse;

class CmsBlocksController extends AppController
{

    /**
     * Add a block by first choosing the widget to use
     *
     * @param string $rowId Row to add this block to
     * @param int $columnIndex Numeric column index
     * @return void
     */
    public function add($rowId = null, $columnIndex = null)
    {
        $cmsRow = $this->CmsBlocks->CmsRows->get($rowId);
        $cmsPage = $this->CmsBlocks->CmsRows->CmsPages->getPage($cmsRow->cms_page_id);

        $cmsBlock = $this->CmsBlocks->newEntity();
        if ($this->request->is('post')) {
            $cmsBlock = $this->CmsBlocks->patchEntity($cmsBlock, $this->request->data);
            $cmsBlock->cms_row_id = $rowId;
            $cmsBlock->column_index = $columnIndex;
            $cmsBlock->status = 'active';

            if ($this->CmsBlocks->save($cmsBlock)) {
                $this->FrontendBridge->setJson('success', true);
                $this->FrontendBridge->setJson('triggerAction', 'editBlock');
                $this->FrontendBridge->setJson('blockId', $cmsBlock->id);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $widgetList = WidgetManager::getWidgetList();
        $widgets = [];
        foreach ($widgetList as $identifier => $config) {
            $widgets[$identifier] = sprintf('%s (%s)', $config['title'], $config['description']);
        }
        $this->set(compact('cmsBlock', 'widgets'));
    }

    /**
     * Dialog for editing a block
     *
     * @param string $id Entity ID
     * @return void
     */
    public function edit($id = null)
    {
        $cmsBlock = $this->CmsBlocks->get($id);
        $widget = WidgetFactory::factory($cmsBlock);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cmsBlock = $this->CmsBlocks->patchEntity($cmsBlock, $this->request->data);
            if ($this->CmsBlocks->save($cmsBlock)) {
                $this->FrontendBridge->setJson('success', true);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->set(compact('cmsBlock', 'widget'));
        $this->FrontendBridge->setJson(compact('cmsBlock'));
    }

    /**
     * Delete a block
     *
     * @param string $id Block ID
     * @return ServiceResponse
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
        try {
            $cmsBlock = $this->CmsBlocks->get($id);
            $this->CmsBlocks->delete($cmsBlock);
        } catch (\Exception $e) {
        }
        return new ServiceResponse('success');
    }

    /**
     * move a block
     *
     * @param string $id Block ID
     * @return ServiceResponse
     */
    public function move($id = null)
    {
        $this->request->allowMethod('post');
        $rowId = $this->request->data('rowId');
        $columnIndex = $this->request->data('columnIndex');
        $position = $this->request->data('position') + 1;
        try {
            $cmsBlock = $this->CmsBlocks->get($id);
            $this->CmsBlocks->moveBlock($cmsBlock, $rowId, $columnIndex, $position);
            $code = 'success';
        } catch (\Exception $e) {
            $code = 'error';
        }
        return new ServiceResponse($code);
    }
}
