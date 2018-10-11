App.Controllers.CmsPagesEditController = Frontend.AppController.extend({
    startup: function() {
        this.addHandlers();
    },
    addHandlers: function() {
        this.$('.cms-page-design .cms-admin-block-panel .btn-edit-block').click(function (e) {
            this.onEditBlock($(e.currentTarget).parents('div.cms-admin-block-panel').data('block-id'));
        }.bind(this));

        this.$('#btn-add-row').click(this.onAddRow.bind(this));
        this.$('.btn-add-block').click(function (e) {
            var $btn = $(e.currentTarget);
            var rowId = $btn.parents('.cms-row').data('row-id');
            var columnIndex = $btn.parents('.cms-row-column').data('column-index');
            this.onAddBlock(rowId, columnIndex);
        }.bind(this));
        
        this.$('.btn-delete-block').click(function (e) {
            var blockId = $(e.currentTarget).parents('.cms-admin-block-panel').data('block-id');
            var confirmation = confirm(this.getVar('confirmMessage'));
            if (confirmation == true) {
                this.onDeleteBlock(blockId);
            } else {
                return;
            }
        }.bind(this));
        
        this.$('.btn-delete-row').click(function (e) {
            var rowId = $(e.currentTarget).parents('.cms-row').data('row-id');
            this.onDeleteRow(rowId);
        }.bind(this));
        
        App.Main.subscribeEvent('ajaxDialog.closed', function (response) {
            if (response.code == 'success' && response.data.frontendData.jsonData.triggerAction == 'editBlock') {
                this.onEditBlock(response.data.frontendData.jsonData.blockId);
            }
        }.bind(this));


        var $designContainer = this.$('.cms-page-design');
        var $sortableBlocks = $designContainer.find('.cms-block-sortable');

        $designContainer.sortable({
            update: function(event, ui) {
                var $row = $(ui.item);
                var position = $row.index();
                this.onMoveRow($row.data('row-id'), position);
            }.bind(this),
        });
        $sortableBlocks.sortable({
            connectWith: '.cms-block-sortable',
            start: function(event, ui) {
                $sortableBlocks.addClass('sortable-start');
            },
            update: function(event, ui) {
                var $block = $(ui.item);
                var columnIndex = $block.parents('.cms-row-column').data('column-index');
                var rowId = $block.parents('.cms-row').data('row-id');
                var position = $block.index();
                this.onMoveBlock($block.data('block-id'), rowId, columnIndex, position);
            }.bind(this),
            stop: function(event, ui) {
                //causes some problems if fired to early
                //$sortableBlocks.removeClass('sortable-start');
            },
            receive: function(event, ui) {
                $sortableBlocks.removeClass('sortable-start');
            }
        });
        $designContainer.disableSelection();
        $sortableBlocks.disableSelection();
    },
    onMoveBlock: function(blockId, newRowId, newColumIndex, newPosition) {
        var url = {
            plugin: 'cms',
            controller: 'CmsBlocks',
            action: 'move',
            pass: [blockId]
        };
        var data = {
            rowId: newRowId,
            columnIndex: newColumIndex,
            position: newPosition
        };
        App.Main.request(url, data, function(response) {
            this.refreshPage();
        }.bind(this));
    },
    onMoveRow: function(rowId, newPosition) {
        var url = {
            plugin: 'cms',
            controller: 'CmsRows',
            action: 'move',
            pass: [rowId]
        };
        var data = {
            position: newPosition
        };
        App.Main.request(url, data, function(response) {
            this.refreshPage();
        }.bind(this));
    },
    onEditBlock: function(blockId) {
        var url = {
            plugin: 'cms',
            controller: 'CmsBlocks',
            action: 'edit',
            pass: [blockId]
        };
        App.Main.Dialog.loadDialog(url,  {
            onDialogClose: function() {
                this.refreshPage();
            }.bind(this)
        });
    },
    onAddRow: function() {
        var url = {
            plugin: 'cms',
            controller: 'CmsRows',
            action: 'add',
            pass: [this.getVar('pageId')]
        };
        App.Main.Dialog.loadDialog(url,  {
            onDialogClose: function() {
                this.refreshPage();
            }.bind(this)
        });
        return false;
    },
    onDeleteBlock: function(blockId) {
        var url = {
            plugin: 'cms',
            controller: 'CmsBlocks',
            action: 'delete',
            pass: [blockId]
        };
        App.Main.request(url, {}, function (response) {
            this.refreshPage();
        }.bind(this));
    },
    onDeleteRow: function(rowId) {
        var url = {
            plugin: 'cms',
            controller: 'CmsRows',
            action: 'delete',
            pass: [rowId]
        };
        App.Main.request(url, {}, function (response) {
            this.refreshPage();
        }.bind(this));
    },
    onAddBlock: function(rowId, columnIndex) {
        var url = {
            plugin: 'cms',
            controller: 'CmsBlocks',
            action: 'add',
            pass: [rowId, columnIndex]
        };

        App.Main.Dialog.loadDialog(url,  {
            onDialogClose: function(arg) {
                console.log(arg);
            }.bind(this)
        });
        return false;
    },
    refreshPage: function() {
        App.Main.UIBlocker.blockElement(this.$('.cms-page-design'));
        window.location.reload();
    }
});