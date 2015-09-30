<?php
    $glideOptions = [];
    if (!empty($block->block_data['height']) && is_numeric($block->block_data['height'])) {
        $glideOptions['h'] = $block->block_data['height'];
    }
    if (!empty($block->block_data['width']) && is_numeric($block->block_data['width'])) {
        $glideOptions['w'] = $block->block_data['width'];
    }
?>
<?= $this->Glide->image($imagePath, $glideOptions) ?>
