<?php
$this->assign('title', __d('cms', 'cms_pages.index.title'));
?>

<h1 class="page-header">
    <?= __d('cms', 'cms_pages.index.title') ?>
    <div class="pull-right">
        <?= $this->CkTools->addButton(__d('cms', 'cms_pages.add')) ?>
    </div>
</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name', __d('cms', 'cms_page.name')) ?></th>
                <th><?= $this->Paginator->sort('slug', __d('cms', 'cms_page.slug')) ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cmsPages as $cmsPage): ?>
                <tr>
                    <td><?= h($cmsPage->name) ?></td>
                    <td><?= h($cmsPage->slug) ?></td>
                    <td>
                        <?= $this->CkTools->button(__d('cms', 'cms_pages.preview'), ['plugin' => false, 'controller' => 'cms_pages', 'action' => 'preview', $cmsPage->id], ['icon' => 'eye', 'target' => '_blank']) ?>
                        <?= $this->CkTools->editButton($cmsPage) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->Paginator->numbers() ?>
