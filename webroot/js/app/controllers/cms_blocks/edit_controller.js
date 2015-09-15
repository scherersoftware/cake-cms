App.Controllers.CmsBlocksEditController = Frontend.AppController.extend({
    _adminWidgetController: null,
    startup: function() {
        this._initAdminWidgetController();
    },
    _initAdminWidgetController: function() {
        var cmsBlock = this.getVar('cmsBlock');
        var widgetName = cmsBlock.widget.split('.')[1];
        var controllerName = widgetName + 'AdminWidgetController';

        if (Cms.AdminWidgetControllers[controllerName] !== undefined) {
            var $dom = this.$('.block-admin-form');
            this._adminWidgetController = new Cms.AdminWidgetControllers[controllerName](cmsBlock, $dom);
        }
    }
});