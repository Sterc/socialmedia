var SocialMedia = function(config) {
    config = config || {};

    SocialMedia.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia, Ext.Component, {
    page    : {},
    window  : {},
    grid    : {},
    tree    : {},
    panel   : {},
    combo   : {},
    config  : {}
});

Ext.reg('socialmedia', SocialMedia);

SocialMedia = new SocialMedia();