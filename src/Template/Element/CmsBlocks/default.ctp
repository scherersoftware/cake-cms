<div class="block" id="<?= $widget->getDomId() ?>">
    <?= $this->element($widget->getViewFolderPath() . $widget->config('template'), $widget->viewVars); ?>
</div>