<div class="cms-page" id="cms-page-<?= $page->id ?>">
    <?php foreach ($page->cms_rows as $row): ?>
        <?= $this->element('Cms.CmsRows/layout', [
            'row' => $row
        ]) ?>
    <?php endforeach; ?>
</div>