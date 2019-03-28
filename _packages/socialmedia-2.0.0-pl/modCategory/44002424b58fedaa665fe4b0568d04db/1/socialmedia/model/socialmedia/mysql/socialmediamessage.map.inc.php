<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

$xpdo_meta_map['SocialMediaMessage'] = [
    'package'       => 'socialmedia',
    'version'       => '1.0',
    'table'         => 'socialmedia_message',
    'extends'       => 'xPDOSimpleObject',
    'tableMeta'     => [
        'engine'        => 'InnoDB'
    ],
    'fields'        => [
        'id'            => null,
        'criteria_id'   => null,
        'key'           => null,
        'source'        => null,
        'user_name'     => null,
        'user_account'  => null,
        'user_image'    => null,
        'user_url'      => null,
        'content'       => null,
        'image'         => null,
        'video'         => null,
        'url'           => null,
        'active'        => null,
        'created'       => null
    ],
    'fieldMeta'     => array(
        'id'            => [
            'dbtype'        => 'int',
            'precision'     => '11',
            'phptype'       => 'integer',
            'null'          => false,
            'index'         => 'pk',
            'generated'     => 'native'
        ],
        'criteria_id'   => [
            'dbtype'        => 'int',
            'precision'     => '11',
            'phptype'       => 'integer',
            'null'          => false
        ],
        'key'           => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'source'        => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false
        ],
        'user_name'     => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'user_account'  => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'user_image'    => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'user_url'      => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'content'       => [
            'dbtype'        => 'text',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'image'         => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'video'         => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'url'           => [
            'dbtype'        => 'varchar',
            'precision'     => '255',
            'phptype'       => 'string',
            'null'          => false,
            'default'       => ''
        ],
        'active'        => [
            'dbtype'        => 'int',
            'precision'     => '1',
            'phptype'       => 'integer',
            'null'          => false,
            'default'       => 1
        ],
        'created'       => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'null'          => false,
            'default'       =>'0000-00-00 00:00:00'
        ]
    ),
    'indexes'       => [
        'PRIMARY'       => [
            'alias'         => 'PRIMARY',
            'primary'       => true,
            'unique'        => true,
            'columns'       => [
                'id'            => [
                    'collation'     => 'A',
                    'null'          => false
                ]
            ]
        ]
    ],
    'aggregates'    =>  [
        'Criteria'      => [
            'local'         => 'criteria_id',
            'class'         => 'SocialMediaCriteria',
            'foreign'       => 'id',
            'owner'         => 'foreign',
            'cardinality'   => 'one'
        ]
    ]
];
