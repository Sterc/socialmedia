<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaMessagesGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SocialMediaMessage';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['socialmedia:default'];

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortField = 'created';

    /**
     * @access public.
     * @var String.
     */
    public $defaultSortDirection = 'DESC';

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'socialmedia.message';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

        $this->setDefaultProperties([
            'dateFormat' => $this->modx->getOption('manager_date_format') . ', ' . $this->modx->getOption('manager_time_format')
        ]);

        return parent::initialize();
    }

    /**
     * @access public.
     * @param xPDOQuery $criteria.
     * @return xPDOQuery.
     */
    public function prepareQueryBeforeCount(xPDOQuery $criteria)
    {
        $criteriaId = $this->getProperty('criteria');

        if (!empty($criteriaId)) {
            $criteria->where([
                'criteria_id' => $criteriaId
            ]);
        }

        $source = $this->getProperty('source');

        if (!empty($source)) {
            $criteria->where([
                'source' => $source
            ]);
        }

        $status = $this->getProperty('status', '');

        if ($status !== '') {
            $criteria->where([
                'active' => $status
            ]);
        }

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $criteria->where([
                'key:LIKE'              => '%' . $query . '%',
                'OR:user_name:LIKE'     => '%' . $query . '%',
                'OR:user_account:LIKE'  => '%' . $query . '%',
                'OR:content:LIKE'       => '%' . $query . '%'
            ]);
        }

        return $criteria;
    }

    /**
     * @access public.
     * @param xPDOObject $object.
     * @return Array.
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = array_merge($object->toArray(), [
            'time_ago'  => '',
            'content'   => trim(preg_replace('/\s+/', ' ', $object->get('content')))
        ]);

        if (in_array($object->get('created'), ['-001-11-30 00:00:00', '-1-11-30 00:00:00', '0000-00-00 00:00:00', null], true)) {
            $array['created'] = '';
        } else {
            $array['created']   = date($this->getProperty('dateFormat'), strtotime($object->get('created')));

            $array['time_ago']  = $object->getTimeAgo();
        }

        return $array;
    }
}

return 'SocialMediaMessagesGetListProcessor';
