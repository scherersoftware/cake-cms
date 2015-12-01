<div class="block <?= $widget->getDomClass() ?>" id="<?= $widget->getDomId() ?>">
    <?= $this->element($widget->getViewFolderPath() . $widget->config('template'), $widget->viewVars); ?>
</div>
