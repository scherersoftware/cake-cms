<?= $this->Html->link($linkText, 'javascript:void(0)', $linkOptions) ?>
<!-- Modal -->
<div class="modal fade" id="cms-modal-<?= $modalPage->id ?>" tabindex="-1" role="dialog" aria-labelledby="cms-modal-label-<?= $modalPage->id ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php if (!empty($modalPage->name)): ?>
            <h4 class="modal-title" id="cms-modal-label-<?= $modalPage->id ?>"><?= $modalPage->name ?></h4>
        <?php endif ?>
      </div>
      <div class="modal-body">
        <div class="cms-page" id="cms-page-<?= $modalPage->id ?>">
            <?php foreach ($modalPage->cms_rows as $row): ?>
                <?= $this->element('Cms.CmsRows/layout', [
                    'row' => $row
                ]) ?>
            <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>