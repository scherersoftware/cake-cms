<?= $this->Form->create($cmsBlock, [
    'class' => 'dialog-ajax-form dialog-ajax-form-close-on-success',
    'novalidate'
]); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>    </button>
    <h4 class="modal-title">
        <?= __d('cms', 'cms_blocks.add.title') ?>
    </h4>
</div>
<div class="modal-body">

    <?= $this->Form->input('widget', [
        'label' => __d('cms', 'cms_block.widget'),
        'options' => $widgets
    ]) ?>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary"><?= __d('cms', 'cms_blocks.add.next') ?></button>
</div>
<?= $this->Form->end() ?>
