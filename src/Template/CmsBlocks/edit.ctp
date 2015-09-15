<?php
if (!$this->request->is('ajax')) {
    $this->CmsAdmin->includeCmsAdminAssets();
    $this->TinyMce->includeAssets();
}
?>

<?= $this->Form->create($cmsBlock, [
    'class' => 'dialog-ajax-form dialog-ajax-form-close-on-success',
    'novalidate'
]); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>    </button>
    <h4 class="modal-title">
        <?= __d('cms', 'cms_blocks.edit.title') ?>
    </h4>
</div>
<div class="modal-body">
    <div class="block-admin-form">
        <?= $this->CmsAdmin->renderBlockAdminForm($cmsBlock) ?>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary"><?= __d('cms', 'cms_blocks.save_block') ?></button>
</div>
<?= $this->Form->end() ?>
