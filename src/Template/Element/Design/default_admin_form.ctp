<?php
/**
 * Create an admin_form.ctp in the Widget's Template folder for rendering contents. If none is
 * present, this view will render instead.
 * 
 * You can use all kinds of form controls in this form and the data collected will be saved
 * serialized in the `data` property of the CMS block.
 * 
 * Make sure you namespace data fields like this:
 * 
 *      $this->Form->input('block_data.my_field');
 * 
 * Available view variables by default are:
 * - CmsBlock $block
 * - AbstractWidget $widget
 */
?>
<div class="alert alert-info">
    <?= __d('cms', 'cms_blocks.no_admin_form_message') ?>
</div>