<?php
use Cms\Model\Entity\CmsRow;

?>
<?= $this->Form->input('layout', [
    'label' => __d('cms', 'cms_row.layout'),
    'options' => CmsRow::getLayouts()
]) ?>