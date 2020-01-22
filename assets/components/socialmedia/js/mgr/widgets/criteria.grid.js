SocialMedia.grid.Criteria = function(config) {
    config = config || {};

    config.tbar = [{
        text        : _('socialmedia.criteria_create'),
        cls         : 'primary-button',
        handler     : this.createCriteria,
        scope       : this
    }, '->', {
        xtype       : 'textfield',
        name        : 'criteria-filter-search',
        id          : 'criteria-filter-search',
        emptyText   : _('search') + '...',
        listeners   : {
            'change'    : {
                fn          : this.filterSearch,
                scope       : this
            },
            'render'    : {
                fn          : function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        keys    : Ext.EventObject.ENTER,
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
        id          : 'criteria-filter-clear',
        text        : _('filter_clear'),
        listeners   : {
            'click'     : {
                fn          : this.clearFilter,
                scope       : this
            }
        }
    }];

    var columns = new Ext.grid.ColumnModel({
        columns     : [{
            header      : _('id'),
            dataIndex   : 'id',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true
        }, {
            header      : _('socialmedia.label_criteria_source'),
            dataIndex   : 'source',
            sortable    : true,
            editable    : false,
            width       : 200,
            fixed       : true,
            renderer    : this.renderSource
        }, {
            header      : _('socialmedia.label_criteria_criteria'),
            dataIndex   : 'criteria',
            sortable    : true,
            editable    : false,
            width       : 200
        }, {
            header      : _('socialmedia.label_criteria_active'),
            dataIndex   : 'active',
            sortable    : true,
            editable    : true,
            width       : 100,
            fixed       : true,
            renderer    : this.renderBoolean,
            editor      : {
                xtype       : 'modx-combo-boolean'
            }
        }, {
            header      : _('last_modified'),
            dataIndex   : 'editedon',
            sortable    : true,
            editable    : false,
            fixed       : true,
            width       : 200,
            renderer    : this.renderDate
        }]
    });

    Ext.applyIf(config, {
        cm          : columns,
        id          : 'socialmedia-grid-criteria',
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/criteria/getlist'
        },
        autosave    : true,
        save_action : 'mgr/criteria/updatefromgrid',
        fields      : ['id', 'source', 'criteria', 'credentials', 'active', 'createdon', 'editedon'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30
    });

    SocialMedia.grid.Criteria.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.grid.Criteria, MODx.grid.Grid, {
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.query = '';

        Ext.getCmp('criteria-filter-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        return [{
            text    : '<i class="x-menu-item-icon icon icon-pencil"></i>' + _('socialmedia.criteria_update'),
            handler : this.updateCriteria,
            scope   : this
        }, '-', {
            text    : '<i class="x-menu-item-icon icon icon-times"></i>' + _('socialmedia.criteria_remove'),
            handler : this.removeCriteria,
            scope   : this
        }];
    },
    createCriteria: function(btn, e) {
        if (this.createCriteriaWindow) {
            this.createCriteriaWindow.destroy();
        }

        this.createCriteriaWindow = MODx.load({
            xtype       : 'socialmedia-window-criteria-create',
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });

        this.createCriteriaWindow.show(e.target);
    },
    updateCriteria: function(btn, e) {
        if (this.updateCriteriaWindow) {
            this.updateCriteriaWindow.destroy();
        }

        this.updateCriteriaWindow = MODx.load({
            xtype       : 'socialmedia-window-criteria-update',
            record      : this.menu.record,
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });

        this.updateCriteriaWindow.setValues(this.menu.record);
        this.updateCriteriaWindow.show(e.target);
    },
    removeCriteria: function(btn, e) {
        MODx.msg.confirm({
            title       : _('socialmedia.criteria_remove'),
            text        : _('socialmedia.criteria_remove_confirm'),
            url         : SocialMedia.config.connector_url,
            params      : {
                action      : 'mgr/criteria/remove',
                id          : this.menu.record.id
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

        return '<span class="icon icon-' + d + '"></span> ' + Ext.util.Format.capitalize(d);
    },
    renderBoolean: function(d, c) {
        c.css = parseInt(d) === 1 || d ? 'green' : 'red';

        return parseInt(d) === 1 || d ? _('yes') : _('no');
    },
    renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('socialmedia-grid-criteria', SocialMedia.grid.Criteria);

SocialMedia.window.CreateCriteria = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        width       : 600,
        autoHeight  : true,
        title       : _('socialmedia.criteria_create'),
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/criteria/create'
        },
        fields      : [{
            layout      : 'column',
            defaults    : {
                layout      : 'form',
                labelSeparator : ''
            },
            items       : [{
                columnWidth : .9,
                items       : [{
                    xtype       : 'textfield',
                    fieldLabel  : _('socialmedia.label_criteria_criteria'),
                    description : MODx.expandHelp ? '' : _('reviews.label_criteria_criteria_desc'),
                    name        : 'criteria',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('socialmedia.label_criteria_criteria_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .1,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('socialmedia.label_criteria_active'),
                    description : MODx.expandHelp ? '' : _('socialmedia.label_criteria_active_desc'),
                    name        : 'active',
                    inputValue  : 1
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('socialmedia.label_criteria_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'socialmedia-combo-sources',
            fieldLabel  : _('socialmedia.label_criteria_source'),
            description : MODx.expandHelp ? '' : _('socialmedia.label_criteria_source_desc'),
            name        : 'source',
            anchor      : '100%',
            allowBlank  : false,
            listeners   : {
                select      : {
                    fn          : this.onHandleSource,
                    scope       : this
                },
                loaded      : {
                    fn          : this.onHandleSource,
                    scope       : this
                }
            }
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('socialmedia.label_criteria_source_desc'),
            cls         : 'desc-under'
        }, {
            id          : 'social-media-source-credentials-create'
        }]
    });

    SocialMedia.window.CreateCriteria.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.window.CreateCriteria, MODx.Window, {
    onHandleSource: function(tf) {
        var panel   = Ext.getCmp('social-media-source-credentials-create');
        var record  = tf.findRecord(tf.valueField, tf.getValue());

        if (record) {
            panel.removeAll();

            var fields  = record.data.fields;
            var slice   = Math.ceil(fields.length / 2);
            var columns = [[], []];

            fields.forEach((function(field, index) {
                var value = '';

                if (this.record.credentials) {
                    value = this.record.credentials[field.name];
                }

                columns[(index + 1) <= slice ? 0 : 1].push({
                    xtype       : 'textfield',
                    fieldLabel  : field.label,
                    description : MODx.expandHelp ? '' : field.description,
                    name        : 'credentials[' + field.name + ']',
                    anchor      : '100%',
                    allowBlank  : false,
                    value       : value
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : field.description,
                    cls         : 'desc-under'
                });
            }).bind(this));

            panel.add({
                layout      : 'column',
                defaults    : {
                    layout      : 'form',
                    labelAlign: 'top',
                    labelSeparator : ''
                },
                items       : [{
                    columnWidth : .5,
                    items       : columns[0]
                }, {
                    columnWidth : .5,
                    items       : columns[1]
                }]
            });

            panel.doLayout();
        }
    }
});

Ext.reg('socialmedia-window-criteria-create', SocialMedia.window.CreateCriteria);

SocialMedia.window.UpdateCriteria = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        width       : 600,
        autoHeight  : true,
        title       : _('socialmedia.criteria_update'),
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/criteria/update'
        },
        fields      : [{
            xtype       : 'hidden',
            name        : 'id'
        }, {
            layout      : 'column',
            defaults    : {
                layout      : 'form',
                labelSeparator : ''
            },
            items       : [{
                columnWidth : .9,
                items       : [{
                    xtype       : 'textfield',
                    fieldLabel  : _('socialmedia.label_criteria_criteria'),
                    description : MODx.expandHelp ? '' : _('reviews.label_criteria_criteria_desc'),
                    name        : 'criteria',
                    anchor      : '100%',
                    allowBlank  : false
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('socialmedia.label_criteria_criteria_desc'),
                    cls         : 'desc-under'
                }]
            }, {
                columnWidth : .1,
                items       : [{
                    xtype       : 'checkbox',
                    fieldLabel  : _('socialmedia.label_criteria_active'),
                    description : MODx.expandHelp ? '' : _('socialmedia.label_criteria_active_desc'),
                    name        : 'active',
                    inputValue  : 1
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('socialmedia.label_criteria_active_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }, {
            xtype       : 'socialmedia-combo-sources',
            fieldLabel  : _('socialmedia.label_criteria_source'),
            description : MODx.expandHelp ? '' : _('socialmedia.label_criteria_source_desc'),
            name        : 'source',
            anchor      : '100%',
            allowBlank  : false,
            listeners   : {
                select      : {
                    fn          : this.onHandleSource,
                    scope       : this
                },
                loaded      : {
                    fn          : this.onHandleSource,
                    scope       : this
                }
            }
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('socialmedia.label_criteria_source_desc'),
            cls         : 'desc-under'
        }, {
            id          : 'social-media-source-credentials-update'
        }]
    });

    SocialMedia.window.UpdateCriteria.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.window.UpdateCriteria, MODx.Window, {
    onHandleSource: function(tf) {
        var panel   = Ext.getCmp('social-media-source-credentials-update');
        var record  = tf.findRecord(tf.valueField, tf.getValue());

        if (record) {
            panel.removeAll();

            var fields  = record.data.fields;
            var slice   = Math.ceil(fields.length / 2);
            var columns = [[], []];

            fields.forEach((function(field, index) {
                var value = '';

                if (this.record.credentials) {
                    value = this.record.credentials[field.name];
                }

                columns[(index + 1) <= slice ? 0 : 1].push({
                    xtype       : 'textfield',
                    fieldLabel  : field.label,
                    description : MODx.expandHelp ? '' : field.description,
                    name        : 'credentials[' + field.name + ']',
                    anchor      : '100%',
                    allowBlank  : false,
                    value       : value
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : field.description,
                    cls         : 'desc-under'
                });
            }).bind(this));

            panel.add({
                layout      : 'column',
                defaults    : {
                    layout      : 'form',
                    labelAlign: 'top',
                    labelSeparator : ''
                },
                items       : [{
                    columnWidth : .5,
                    items       : columns[0]
                }, {
                    columnWidth : .5,
                    items       : columns[1]
                }]
            });

            panel.doLayout();
        }
    }
});

Ext.reg('socialmedia-window-criteria-update', SocialMedia.window.UpdateCriteria);

SocialMedia.combo.Sources = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url         : SocialMedia.config.connector_url,
        baseParams  : {
            action      : 'mgr/sources/getlist'
        },
        fields      : ['type', 'label', 'fields'],
        hiddenName  : 'source',
        valueField  : 'type',
        displayField : 'label',
        tpl         : new Ext.XTemplate('<tpl for=".">' +
            '<div class="x-combo-list-item {type}">' +
                '<span class="icon icon-{type}"></span> {label}' +
            '</div>' +
        '</tpl>')
    });

    SocialMedia.combo.Sources.superclass.constructor.call(this,config);
};

Ext.extend(SocialMedia.combo.Sources, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-sources', SocialMedia.combo.Sources);