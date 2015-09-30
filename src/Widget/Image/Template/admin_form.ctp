<?= $this->TinyMce->picker('block_data.image_path', [
    'label' => __('cms.image')
]) ?>
<?= $this->Form->input('textarea_' . rand(), [
    'type' => 'textarea',
    'class' => 'tinymce hidden',
    'label' => ''
]); ?>

<?= $this->Form->input('block_data.layout', [
    'label' => __('cms.layout'),
    'type' => 'select',
    'options' => $layouts
]) ?>

<?= $this->Form->input('block_data.height', [
    'label' => __('cms.height') . '*',
    'type' => 'number',
    'append' => 'px'
]) ?>

<?= $this->Form->input('block_data.width', [
    'label' => __('cms.width') . '*',
    'type' => 'number',
    'append' => 'px'
]) ?>

<div class="alert alert-info">
    * <?= __('cms.glide_proportionally_resize_info') ?>
</div>
