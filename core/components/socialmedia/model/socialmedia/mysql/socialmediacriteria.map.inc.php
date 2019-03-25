<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

$xpdo_meta_map['SocialMediaCriteria'] = [
    'package'       => 'socialmedia',
    'version'       => '1.0',
    'table'         => 'socialmedia_criteria',
    'extends'       => 'xPDOSimpleObject',
    'fields'        => [
        'id'            => null,
        'source'        => null,
        'criteria'      => null,
        'active'        => null,
        'createdon'     => null,
        'editedon'      => null
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
        'source'        => [
            'dbtype'        => 'varchar',
            'precision'     => '75',
            'phptype'       => 'string',
            'null'          => false
        ],
        'criteria'      => [
            'dbtype'        => 'text',
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
        'createdon'     => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'null'          => false,
            'default'       =>'0000-00-00 00:00:00'
        ],
        'editedon'      => [
            'dbtype'        => 'timestamp',
            'phptype'       => 'timestamp',
            'attributes'    => 'ON UPDATE CURRENT_TIMESTAMP',
            'null'          => false,
            'default'       => '0000-00-00 00:00:00'
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
        'Messages'      => [
            'local'         => 'id',
            'class'         => 'SocialMediaMessage',
            'foreign'       => 'criteria_id',
            'owner'         => 'local',
            'cardinality'   => 'many'
        ]
    ]
];
