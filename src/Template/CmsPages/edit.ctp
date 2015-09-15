<?php
    echo $this->Html->css("https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css");
    echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js");
    $this->assign('title', __d('cms', 'cms_pages.edit'));
?>

<h1 class="page-header">
    <?= __d('cms', 'cms_pages.edit') ?>
    <div class="pull-right">
        <?= $this->ListFilter->backToListButton() ?>
    </div>
</h1>

<ul class="nav nav-tabs responsive">
    <li>
        <a href="#page-design" data-toggle="tab"><?= __d('cms', 'cms_pages.edit.design') ?></a>
    </li>
    <li>
        <a href="#page-data" data-toggle="tab"><?= __d('cms', 'cms_pages.edit.data') ?></a>
    </li>
</ul>
<div class="tab-content tab-content-bordered">
    <div class="tab-pane" id="page-design">
        <?= $this->element('../CmsPages/design') ?>
    </div>
    <div class="tab-pane" id="page-data">
        <br>
        <?= $this->Form->create($cmsPage, [
            'align' => 'horizontal',
            'url' => [
                'action' => 'edit',
                $cmsPage->id,
                '#' => 'page-data'
            ]
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
    </div>
</div>

