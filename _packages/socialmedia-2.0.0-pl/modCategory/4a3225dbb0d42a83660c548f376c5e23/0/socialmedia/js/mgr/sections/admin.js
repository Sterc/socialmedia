Ext.onReady(function() {
    MODx.load({
        xtype : 'socialmedia-page-admin'
    });
});

SocialMedia.page.Admin = function(config) {
    config = config || {};

    config.buttons = [];

    if (SocialMedia.config.branding_url) {
        config.buttons.push({
            text        : 'SocialMedia ' + SocialMedia.config.version,
            cls         : 'x-btn-branding',
            handler     : this.loadBranding
        });
    }

    config.buttons.push({
        text   : '<i class="icon icon-cogs"></i>' + _('socialmedia.default_view'),
        handler: this.toDefaultView,
        scope  : this
    });

    if (SocialMedia.config.branding_url_help) {
        config.buttons.push({
            text        : _('help_ex'),
            handler     : MODx.loadHelpPane,
            scope       : this
        });
    }

    Ext.applyIf(config, {
        components  : [{
            xtype       : 'socialmedia-panel-admin',
            renderTo    : 'socialmedia-panel-admin-div'
        }]
    });

    SocialMedia.page.Admin.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.page.Admin, MODx.Component, {
    loadBranding: function(btn) {
        window.open(SocialMedia.config.branding_url);
    },
    toDefaultView : function() {
        MODx.loadPage('home', 'namespace=' + MODx.request.namespace);
    }
});

Ext.reg('socialmedia-page-admin', SocialMedia.page.Admin);