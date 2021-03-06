<?php
$this->assign('title', __d('cms', 'cms_pages.index.title'));
?>

<h1 class="page-header">
    <?= __d('cms', 'cms_pages.index.title') ?>
    <div class="pull-right">
        <?= $this->CkTools->addButton(__d('cms', 'cms_pages.add')) ?>
    </div>
</h1>

<div class="row">
    <div class="col-lg-12">
        <?= $this->ListFilter->openForm(); ?>
        <?= $this->ListFilter->filterWidget('CmsPages.fulltext_search', [
            'inputOptions' => [
                'label' => false,
                'placeholder' => __('cms_pages.search'),
                'prepend' => '<i class="fa fa-search"></i>'
            ]
        ]) ?>
        <?= $this->ListFilter->closeForm(false, false); ?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name', __d('cms', 'cms_page.name')) ?></th>
                <th><?= $this->Paginator->sort('slug', __d('cms', 'cms_page.slug')) ?></th>
                <th><?= $this->Paginator->sort('slug', __d('cms', 'cms_page.description')) ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cmsPages as $cmsPage): ?>
                <tr>
                    <td><?= h($cmsPage->name) ?></td>
                    <td><?= h($cmsPage->slug) ?></td>
                    <td><?= h($cmsPage->description) ?></td>
                    <td>
                        <?php
                            $previewUrlTemp = $previewUrl;
                            $previewUrlTemp[] = $cmsPage->id;
                        ?>
                        <?= $this->CkTools->button(__d('cms', 'cms_pages.preview'), $previewUrlTemp, ['icon' => 'eye', 'target' => '_blank']) ?>
                        <?= $this->CkTools->editButton($cmsPage) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->Paginator->numbers() ?>
