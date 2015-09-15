<div class="row">
    <?php $responsiveClass = $row->hasBlockType(['App.TeaserHero']) ? 'teaser-mobile-full ' : ''; ?>
    <?php foreach ($this->Cms->getRowColumnLayout($row) as $columnIndex => $config): ?>
        <div class="<?= $responsiveClass ?><?= $config['class'] ?>">
            <?= $this->Cms->renderBlocksForColumnOfRow($row, $columnIndex) ?>
        </div>
    <?php endforeach; ?>
</div>
