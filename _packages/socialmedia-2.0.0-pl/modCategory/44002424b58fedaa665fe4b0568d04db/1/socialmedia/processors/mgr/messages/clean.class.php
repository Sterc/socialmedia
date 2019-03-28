<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaMessageCleanProcessor extends modProcessor
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
    public $objectType = 'socialmedia.message';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function process()
    {
        $amount = 0;

        foreach ($this->modx->getCollection('SocialMediaCriteria') as $type) {
            $criteria = $this->modx->newQuery('SocialMediaMessage');

            $criteria->where([
                'criteria_id'   => $type->get('id'),
                'active'        => 1
            ]);

            $criteria->sortby('created', 'DESC');
            $criteria->limit(1, (int) $this->getProperty('limit'));

            $message = $this->modx->getObject('SocialMediaMessage', $criteria);

            if ($message) {
                $criteria = $this->modx->newQuery('SocialMediaMessage');

                $criteria->where([
                    'criteria_id'   => $type->get('id'),
                    'created:<='    => $message->get('created')
                ]);

                foreach ($this->modx->getCollection('SocialMediaMessage', $criteria) as $message) {
                    if ($message->remove()) {
                        $amount++;
                    }
                }
            }
        }

        return $this->success($this->modx->lexicon('socialmedia.messages_clean_success', [
            'amount' => $amount
        ]));
    }
}

return 'SocialMediaMessageCleanProcessor';
