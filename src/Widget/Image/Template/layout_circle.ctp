<style type="text/css" media="screen">
    .cms-image-layout-circle {
        border: 3px solid #00b2cc;
        display: inline-block;
        border-radius: 50%;
        overflow: hidden;
    }
</style>
<div class="cms-image-layout-circle">
    <?= $this->Glide->image($imagePath, ['w' => 500, 'h' => 500, 'fit' => 'crop']) ?>
</div>