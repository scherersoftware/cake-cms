<?php
$this->Html->css('Cms.cms', ['block' => true]);
$this->CmsAdmin->includeCmsAdminAssets();
$this->TinyMce->includeAssets();

?>
<br>
<div class="clearfix">
    <div class="pull-right">
         <?= $this->CkTools->button(__d('cms', 'cms_pages.preview'), ['plugin' => 'Cms', 'controller' => 'CmsPages', 'action' => 'show', $cmsPage->id], ['icon' => 'eye', 'target' => '_blank']) ?>
        <div class="btn btn-default btn-xs" id="btn-add-row"><i class="fa fa-plus"></i> <?= __d('cms', 'cms_rows.add_row') ?></div>
    </div>
</div>
<hr>

<div class="cms-page-design" id="sortable-row">
    <?php foreach ($cmsPage->cms_rows as $row): ?>
        <div class="cms-row" data-row-id="<?= $row->id ?>">
            <div class="cms-row-head">
                <?= __d('cms', 'cms_row.layout') ?> <?= $row->layout ?>
                <div class="pull-right">
                    <?= $this->Html->link('<i class="fa fa-close"></i>', 'javascript:', [
                        'class' => 'btn btn-xs btn-danger btn-delete-row',
                        'title' => __d('cms', 'cms_rows.delete_row'),
                        'escape' => false,
                        'confirm' => __d('cms', 'cms_rows.really_delete_row')
                    ]) ?>
                </div>
            </div>
            <br>
            <div class="row cms-row-columns">
                <?php foreach ($this->Cms->getRowColumnLayout($row) as $columnIndex => $config): ?>
                    <div class="<?= $config['class'] ?> cms-row-column" data-column-index="<?= $columnIndex ?>">
                        <div class="cms-block-sortable">
                            <?php foreach ($row->getBlocksForColumn($columnIndex) as $block): ?>
                                <?= $this->CmsAdmin->renderBlockAdminPreview($block) ?>
                            <?php endforeach; ?>
                        </div>
                        <a href="javascript:" class="btn btn-default btn-block btn-xs btn-add-block">
                            <i class="fa fa-plus unsortable"></i> <?= __d('cms', 'cms_rows.add_block') ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
</div>