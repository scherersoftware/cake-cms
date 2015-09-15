Cms.AdminWidgetController = Class.extend({
    cmsBlock: {},
    _dom: null,
	init: function(cmsBlock, $dom) {
        this.cmsBlock = cmsBlock;
        this._dom = $dom;
        this.$ = this._dom.find.bind(this._dom);
        this.startup();
	},
    startup: function() {}
});