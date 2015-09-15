Cms.WidgetController = Class.extend({
    uniqueId: null,
    cmsBlock: {},
    data: {},
    _dom: null,
	init: function(uniqueId, widgetData) {
        this.uniqueId = uniqueId;
        this.data = widgetData;
        this._dom = $('#' + uniqueId.replace('.', '-'));
        this.$ = this._dom.find.bind(this._dom);
        this.startup();
	},
    startup: function() {},
    onJmlLoaded: function(callback) {
        if (this.jmlLoaded == true ) {
            return;
        }

        if (jQuery.mobile) {
            callback();
            this.jmlLoaded = true;
        } else {
            $(document).on("mobileinit", function() {
                callback();
                this.jmlLoaded = true;
            });
        }
    }
});
