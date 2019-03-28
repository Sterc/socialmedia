SocialMedia.grid.Messages = function(config) {
    config = config || {};

    config.tbar = [{
        text        : _('bulk_actions'),
        menu        : [{
            text        : '<i class="x-menu-item-icon icon icon-eye"></i>' + _('socialmedia.messages_activate_selected'),
            handler     : this.activateSelectedMessages,
            scope       : this
        }, {
            text        : '<i class="x-menu-item-icon icon icon-eye-slash"></i>' + _('socialmedia.messages_deactivate_selected'),
            handler     : this.deactivateSelectedMessages,
            scope       : this
        }, '-', {
            text        : '<i class="x-menu-item-icon icon icon-history"></i>' + _('socialmedia.messages_clean'),
            handler     : this.cleanMessages,
            scope       : this
        }, '-', {
            text        : '<i class="x-menu-item-icon icon icon-times"></i>' +  _('socialmedia.messages_reset'),
            handler     : this.removeMessages,
            scope       : this
        }]
    }, '->', {
        xtype       : 'socialmedia-combo-criteria',
        name        : 'socialmedia-filter-criteria',
        id          : 'socialmedia-filter-criteria',
        emptyText   : _('socialmedia.filter_criteria'),
        listeners   : {
            'select'    : {
                fn          : this.filterCriteria,
                scope       : this
            }
        }
    }, {
        xtype       : 'socialmedia-combo-source',
        name        : 'socialmedia-filter-source',
        id          : 'socialmedia-filter-source',
        emptyText   : _('socialmedia.filter_source'),
        listeners   : {
            'select'    : {
                fn          : this.filterSource,
                scope       : this
            }
        }
    }, {
        xtype       : 'socialmedia-combo-status',
        name        : 'socialmedia-filter-status',
        id          : 'socialmedia-filter-status',
        emptyText   : _('socialmedia.filter_status'),
        listeners   : {
            'select'    : {
                fn          : this.filterStatus,
                scope       : this
            }
        }
    }, '-', {
        xtype       : 'textfield',
        name        : 'socialmedia-filter-search',
        id          : 'socialmedia-filter-search',
        emptyText   : _('search')+'...',
        listeners   : {
            'change'    : {
                fn          : this.filterSearch,
                scope       : this
            },
            'render'    : {
                fn          : function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key     : Ext.EventObject.ENTER,
                        fn      : this.blur,
                        scope   : cmp
                    });
                },
                scope       : this
            }
        }
    }, {
        xtype       : 'button',
        cls         : 'x-form-filter-clear',
        id          : 'socialmedia-filter-clear',
        text        : _('filter_clear'),
        listeners   : {
            'click'     : {
                fn          : this.clearFilter,
                scope       : this
            }
        }
    }];
    
    var sm = new Ext.grid.CheckboxSelectionModel();
    
    var columns = new Ext.grid.ColumnModel({
        columns     : [sm, {
            header      : _('socialmedia.label_message_source'),
            dataIndex   : 'source',
            sortable    : true,
            editable    : false,
            width       : 100,
            fixed       : true,
            renderer    : this.renderSource
        }, {
            header      : _('socialmedia.label_message_user_account'),
            dataIndex   : 'user_name',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true,
            renderer    : this.renderUserAccount
        }, {
            header      : _('socialmedia.label_message_content'),
            dataIndex   : 'content',
            sortable    : true,
            editable    : false,
            width       : 250,
            renderer    : this.renderContent
        }, {
            header      : _('socialmedia.label_message_status'),
            dataIndex   : 'active',
            sortable    : true,
            editable    : true,
            width       : 100,
            fixed       : true,
            renderer    : this.renderStatus,
            editor      : {
                xtype       : 'socialmedia-combo-status'
            }
        }, {
            header      : _('socialmedia.label_message_created'),
            dataIndex   : 'time_ago',
            sortable    : true,
            editable    : false,
            fixed       : true,
            width       : 200,
            renderer    : this.renderDate
        }]
    });
    
    Ext.applyIf(config, {
        sm          : sm,
        cm          : columns,
        id          : 'socialmedia-grid-messages',
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/messages/getlist'
        },
        autosave    : true,
        save_action : 'mgr/messages/updatefromgrid',
        fields      : ['id', 'criteria_id', 'key', 'source', 'user_name', 'user_account', 'user_image', 'user_account', 'user_url', 'content', 'image', 'video', 'url', 'active', 'created', 'time_ago'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy      : 'created'
    });
    
    SocialMedia.grid.Messages.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.grid.Messages, MODx.grid.Grid, {
    filterCriteria: function(tf, nv, ov) {
        this.getStore().baseParams.criteria = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    filterSource: function(tf, nv, ov) {
        this.getStore().baseParams.source = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    filterStatus: function(tf, nv, ov) {
        this.getStore().baseParams.status = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.criteria = '';
        this.getStore().baseParams.source   = '';
        this.getStore().baseParams.status   = '';
        this.getStore().baseParams.query    = '';

        Ext.getCmp('socialmedia-filter-criteria').reset();
        Ext.getCmp('socialmedia-filter-source').reset();
        Ext.getCmp('socialmedia-filter-status').reset();
        Ext.getCmp('socialmedia-filter-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        var menu = [];

        menu.push({
            text  : '<i class="x-menu-item-icon icon icon-external-link"></i>' + _('socialmedia.message_show', {
                source : Ext.util.Format.capitalize(this.menu.record.source)
            }),
            handler   : this.showMessage
        }, '-');

        if (parseInt(this.menu.record.active) === 1) {
            menu.push({
                text    : '<i class="x-menu-item-icon icon icon-eye-slash"></i>' + _('socialmedia.message_deactivate'),
                handler : this.deactivateMessage
            });
        } else {
            menu.push({
                text    : '<i class="x-menu-item-icon icon icon-eye"></i>' + _('socialmedia.message_activate'),
                handler : this.activateMessage
            });
        }

        return menu;
    },
    showMessage: function(btn, e) {
        window.open(this.menu.record.url);
    },
    activateMessage: function(btn, e) {
        MODx.msg.confirm({
            title       : _('socialmedia.message_activate'),
            text        : _('socialmedia.message_activate_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/messages/update',
                id          : this.menu.record.id,
                active      : 1
            },
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });
    },
    deactivateMessage: function(btn, e) {
        MODx.msg.confirm({
            title       : _('socialmedia.message_deactivate'),
            text        : _('socialmedia.message_deactivate_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/messages/update',
                id          : this.menu.record.id,
                active      : 0
            },
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });
    },
    activateSelectedMessages: function(btn, e) {
        var cs = this.getSelectedAsList();

        MODx.msg.confirm({
            title       : _('socialmedia.messages_activate_selected'),
            text        : _('socialmedia.messages_activate_selected_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/messages/activateselected',
                type        : 1,
                ids         : cs
            },
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.getSelectionModel().clearSelections(true);

                        this.refresh();
                    },
                    scope       : this
                }
            }
        });
    },
    deactivateSelectedMessages: function(btn, e) {
        var cs = this.getSelectedAsList();

        MODx.msg.confirm({
            title       : _('socialmedia.messages_deactivate_selected'),
            text        : _('socialmedia.messages_deactivate_selected_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/messages/activateselected',
                type        : 0,
                ids         : cs
            },
            listeners   : {
                'success'   : {
                    fn          : function() {
                        this.getSelectionModel().clearSelections(true);

                        this.refresh();
                    },
                    scope       : this
                }
            }
        });
    },
    cleanMessages: function(btn, e) {
        if (this.cleanMessagesWindow) {
            this.cleanMessagesWindow.destroy();
        }

        this.cleanMessagesWindow = MODx.load({
            xtype       : 'socialmedia-window-messages-clean',
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : function(record) {
                        MODx.msg.status({
                            title   : _('success'),
                            message : record.a.result.message,
                            delay   : 4
                        });

                        this.refresh();
                    },
                    scope       : this
                }
            }
        });

        this.cleanMessagesWindow.show(e.target);
    },
    removeMessages: function(btn, e) {
        MODx.msg.confirm({
            title       : _('socialmedia.messages_reset'),
            text        : _('socialmedia.messages_reset_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/messages/remove'
            },
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });
    },
    renderSource: function(d, c, e) {
        c.css = e.json.source;

        return String.format('<span class="icon icon-{0}"></span> {1}', d, Ext.util.Format.capitalize(d));
    },
    renderUserAccount: function(d, c, e) {
        return String.format('<a href="{0}" target="_blank" title="{1}" class="x-grid-link">{2}</a>', e.json.user_url, d, d);
    },
    renderContent: function(d, c, e) {
        if (Ext.isEmpty(d)) {
            d = '<i>' + _('socialmedia.unknow_message') + '</i>';
        }

        return String.format('<a href="{0}" target="_blank" title="{1}" class="x-grid-link">{2}</a>', e.json.url, _('socialmedia.show_source', {
            'source' : Ext.util.Format.capitalize(e.json.source)
        }), d);
    },
    renderStatus: function(d, c) {
        c.css = parseInt(d) === 1 ? 'green' : 'red';

        return parseInt(d) === 1 ? _('socialmedia.activate') : _('socialmedia.deactivate');
    },
    renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('socialmedia-grid-messages', SocialMedia.grid.Messages);

SocialMedia.window.CleanMessages = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        autoHeight  : true,
        width       : 500,
        title       : _('socialmedia.messages_clean'),
        cls         : 'x-window-formit',
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/messages/clean'
        },
        fields      : [{
            xtype       : 'modx-panel',
            items       : [{
                xtype       : 'label',
                html        : _('socialmedia.label_clean_label')
            }, {
                xtype       : 'numberfield',
                name        : 'limit',
                minValue    : 1,
                maxValue    : 9999999999,
                value       : 15,
                width       : 75,
                allowBlank  : false,
                style       : 'margin: 0 10px;'
            }, {
                xtype       : 'label',
                html        : _('socialmedia.label_clean_desc')
            }]
        }],
        keys        : [],
        saveBtnText : _('socialmedia.messages_clean'),
        waitMsg     : _('socialmedia.messages_clean_executing')
    });

    SocialMedia.window.CleanMessages.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.window.CleanMessages, MODx.Window);

Ext.reg('socialmedia-window-messages-clean', SocialMedia.window.CleanMessages);

SocialMedia.combo.Status = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : [
                ['0', _('socialmedia.deactivate')],
                ['1', _('socialmedia.activate')]
            ]
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'active',
        valueField  : 'type',
        displayField : 'label',
        mode        : 'local'
    });

    SocialMedia.combo.Status.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.combo.Status, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-status', SocialMedia.combo.Status);

SocialMedia.combo.Source = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/sources/getlist'
        },
        fields      : ['type', 'label'],
        hiddenName  : 'source',
        pageSiz     : 15,
        valueField  : 'type',
        displayField : 'label',
        tpl         : new Ext.XTemplate('<tpl for=".">' +
            '<div class="x-combo-list-item {type}">' +
                '<span class="icon icon-{type}"></span> {label}' +
            '</div>' +
        '</tpl>')
    });
    
    SocialMedia.combo.Source.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.combo.Source, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-source', SocialMedia.combo.Source);

SocialMedia.combo.Criteria = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/criteria/getnodes'
        },
        fields      : ['id', 'source', 'criteria'],
        hiddenName  : 'criteria',
        pageSiz     : 15,
        valueField  : 'id',
        displayField : 'source',
        tpl         : new Ext.XTemplate('<tpl for=".">' +
            '<div class="x-combo-list-item {source}">' +
                '<span class="icon icon-{source}"></span> {criteria}' +
            '</div>' +
        '</tpl>')
    });

    SocialMedia.combo.Criteria.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.combo.Criteria, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-criteria', SocialMedia.combo.Criteria);