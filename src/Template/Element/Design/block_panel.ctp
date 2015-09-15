<?php
    use Cake\Utility\Hash;
?>
<div class="panel panel-default cms-admin-block-panel" data-block-id="<?= $block->id ?>">
    <div class="panel-heading">
        <div class="btn-group pull-right">
            <a href="javascript:" class="btn btn-default btn-xs btn-edit-block"><?= __d('cms', 'cms_pages.design.edit_block') ?></a>
            <?= $this->Html->link('<i class="fa fa-close"></i>', 'javascript:', [
                'escape' => false,
                'class' => 'btn btn-danger btn-xs btn-delete-block',
                'title' => __d('cms', 'cms_pages.design.delete_block')
            ]) ?>
        </div>
        <?= $widget->getTitle() ?>
    </div>
    <div class="panel-body">
        <?= $this->element($previewElement, Hash::merge([
            'previewElement' => $previewElement,
            'widget' => $widget,
            'block' => $block
        ], $widget->viewVars));
        ?>
    </div>
</div>
