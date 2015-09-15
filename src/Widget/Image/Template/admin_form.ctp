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