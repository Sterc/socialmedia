<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(__DIR__) . '/socialmediasnippets.class.php';

class SocialMediaSnippet extends SocialMediaSnippets
{
    /**
     * @access public.
     * @var Array.
     */
    public $properties = [
        'criteria'              => '',
        'filter'                => '',
        'where'                 => '{"active": "1"}',
        'sortby'                => '{"created": "DESC"}',
        'pinEnabled'            => true,
        'limit'                 => 10,
        'group'                 => '',
        'tpl'                   => '@FILE elements/chunks/item.chunk.tpl',
        'tplWrapper'            => '@FILE elements/chunks/wrapper.chunk.tpl',
        'tplWrapperEmpty'       => '',
        'tplGroup'              => '',
        'tpls'                  => '{}',
        'usePdoTools'           => false,
        'usePdoElementsPath'    => false
    ];

    /**
     * @access public.
     * @param Array $properties.
     * @return String.
     */
    public function run(array $properties = [])
    {
        $this->setProperties($properties);

        $sources    = $this->getAvailableSources(true);
        $criterias  = array_filter(explode(',', $this->getProperty('criteria')));
        $filters    = array_filter(explode(',', $this->getProperty('filter')));
        $tpls       = json_decode($this->getProperty('tpls'), true);
        $where      = json_decode($this->getProperty('where'), true);
        $sortby     = json_decode($this->getProperty('sortby'), true);
        $limit      = (int) $this->getProperty('limit');
        $group      = $this->getProperty('group');

        $output     = [];

        $criteria = $this->modx->newQuery('SocialMediaMessage');

        if ($where) {
            $criteria->where($where);
        }

        if (count($criterias) >= 1) {
            $criteria->where([
                'criteria_id:IN' => $criterias
            ]);
        }

        if (count($filters) >= 1) {
            $filter = [];

            foreach ($filters as $value) {
                $filter[] = [
                    'content:LIKE' => '%' . trim($value) . '%'
                ];
            }

            $criteria->where($filter, xPDOQuery::SQL_OR);
        }

        if ((boolean) $this->getProperty('pinEnabled')) {
            $criteria->sortby('pin', 'DESC');
        }

        if ($sortby) {
            foreach ((array) $sortby as $key => $value) {
                if (in_array($value, ['RAND', 'RAND()'], true)) {
                    $criteria->sortby('RAND()');
                } else {
                    $criteria->sortby($key, $value);
                }
            }
        }

        if ($limit > 1) {
            $criteria->limit($limit);
        }

        $data = $this->modx->getCollection('SocialMediaMessage', $criteria);

        if (!empty($group)) {
            $groupData = [];

            foreach ($data as $key => $message) {
                if (in_array($group, ['source', 'user_name', 'user_account'], true)) {
                    $groupData[$message->get($group)][] = $message;
                }
            }

            $data = $groupData;
        } else {
            $data = [
                $data
            ];
        }

        foreach ($data as $group => $groupData) {
            $groupOutput = [];

            $idx = 1;

            foreach ((array) $groupData as $message) {
                $tpl = $this->getProperty('tpl');
                $content = $message->get('content');

                if ($sources[$message->get('source')]) {
                    $content = $sources[$message->get('source')]->getHtmlFormat($content);
                }

                if ($tpls && isset($tpls[$message->get('source')])) {
                    $tpl = $tpls[$message->get('source')];
                }

                $groupOutput[] = $this->getChunk($tpl, array_merge($message->toArray(), [
                    'idx'           => $idx,
                    'content_html'  => $content,
                    'time_ago'      => $message->getTimeAgo()
                ]));

                $idx++;
            }

            $tplGroup = $this->getProperty('tplGroup');

            if (!empty($tplGroup)) {
                $output[] = $this->getChunk($tplGroup, [
                    'output'    => implode(PHP_EOL, $groupOutput),
                    'group'     => $group
                ]);
            } else {
                $output[] = implode(PHP_EOL, $groupOutput);
            }
        }

        if (!empty($output)) {
            $tplWrapper = $this->getProperty('tplWrapper');

            if (!empty($tplWrapper)) {
                return $this->getChunk($tplWrapper, [
                    'output' => implode(PHP_EOL, $output)
                ]);
            }

            return implode(PHP_EOL, $output);
        }

        $tplWrapperEmpty = $this->getProperty('tplWrapperEmpty');

        if (!empty($tplWrapperEmpty)) {
            return $this->getChunk($tplWrapperEmpty);
        }

        return '';
    }
}
