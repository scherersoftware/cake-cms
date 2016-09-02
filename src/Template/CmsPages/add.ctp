<?php

$this->assign('title', __d('cms', 'cms_pages.add'));
?>

<h1 class="page-header">
    <?= __d('cms', 'cms_pages.add') ?>
</h1>

<?= $this->Form->create($cmsPage, [
    'align' => 'horizontal'
]) ?>

<?= $this->Form->input('name', [
    'label' => __d('cms', 'cms_page.name')
]) ?>
<?= $this->Form->input('slug', [
    'label' => __d('cms', 'cms_page.slug')
]) ?>
<?= $this->Form->input('description', [
    'label' => __d('cms', 'cms_page.description')
]) ?>


<?= $this->CkTools->formButtons() ?>


<?= $this->Form->end() ?>