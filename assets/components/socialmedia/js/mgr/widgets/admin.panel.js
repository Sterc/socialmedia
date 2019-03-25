SocialMedia.panel.Admin = function(config) {
    config = config || {};

    Ext.apply(config, {
        id          : 'socialmedia-panel-home',
        cls         : 'container',
        items       : [{
            html        : '<h2>' + _('socialmedia') + '</h2>',
            cls         : 'modx-page-header'
        }, {
            layout      : 'form',
            items       : [{
                html            : '<p>' + _('socialmedia.criteria_desc') + '</p>',
                bodyCssClass    : 'panel-desc'
            }, {
                xtype           : 'socialmedia-grid-criteria',
                cls             : 'main-wrapper',
                preventRender   : true
            }]
        }]
    });

    SocialMedia.panel.Admin.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.panel.Admin, MODx.FormPanel);

Ext.reg('socialmedia-panel-admin', SocialMedia.panel.Admin);