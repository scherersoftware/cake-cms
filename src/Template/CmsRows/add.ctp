<?= $this->Form->create($cmsRow, [
    'class' => 'dialog-ajax-form dialog-ajax-form-close-on-success',
    'novalidate'
]); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>    </button>
    <h4 class="modal-title">
        <?= __d('cms', 'cms_rows.add.title') ?>
    </h4>
</div>
<div class="modal-body">
    <?= $this->element('../CmsRows/form') ?>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary"><?= __d('cms', 'cms_rows.save_row') ?></button>
</div>
<?= $this->Form->end() ?>
