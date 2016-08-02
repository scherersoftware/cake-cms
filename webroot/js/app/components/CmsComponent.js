App.Components.CmsComponent = Frontend.Component.extend({
    _widgetControllers: {},
    startup: function() {
    },
    initWidgets: function() {
        var cmsData = this.Controller.getVar('Cms');
        var widgetData, className;
        if (cmsData && cmsData.widgets) {
            for (var uniqueId in cmsData.widgets) {
                widgetData = cmsData.widgets[uniqueId];
                if (typeof widgetData !== 'object') {
                    continue;
                }
                className = widgetData.identifier.split('.')[1] + 'WidgetController';
                if (Cms.WidgetControllers[className]) {
                    this._widgetControllers[uniqueId] = new Cms.WidgetControllers[className](uniqueId, widgetData);
                }
            }
        }
    }
});
