<?php
$this->assign('title', $page->name);
?>

<?= $this->Cms->renderPage($page); ?>