<?php
$animateOnce = true;
if(isset($widget->viewVars['block']->block_data['animate_once'])) {
    $animateOnce = $widget->viewVars['block']->block_data['animate_once'];
}
?>

<div class="animatedParent <?= ($animateOnce) ? 'animateOnce' : '' ?>">
    <div class="block <?= $widget->getDomClass() ?> <?= $widget->getDomAnimationClasses() ?>" id="<?= $widget->getDomId() ?>">
        <?= $this->element($widget->getViewFolderPath() . $widget->config('template'), $widget->viewVars); ?>
    </div>
</div>
