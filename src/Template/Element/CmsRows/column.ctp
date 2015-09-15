<?php foreach ($blocks as $block): ?>
    <?= $block->render($this->request, $this) ?>
<?php endforeach; ?>