<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaMessagesActivateSelectedProcessor extends modProcessor
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
        $this->modx->cacheManager->refresh([
            'socialmedia' => []
        ]);

        foreach ((array) explode(',', $this->getProperty('ids')) as $key => $value) {
            $object = $this->modx->getObject($this->classKey, $value);

            if ($object) {
                $object->fromArray([
                    'active' => $this->getProperty('type')
                ]);

                $object->save();
            }
        }

        $this->modx->invokeEvent('onSocialMediaUpdate');

        return $this->outputArray([]);
    }
}

return 'SocialMediaMessagesActivateSelectedProcessor';
