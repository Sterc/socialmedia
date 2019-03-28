<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaMessageUpdateProcessor extends modObjectUpdateProcessor
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
    public function afterSave()
    {
        $this->modx->cacheManager->refresh([
            'socialmedia' => []
        ]);

        $this->modx->invokeEvent('onSocialMediaUpdate');

        return parent::afterSave();
    }
}

return 'SocialMediaMessageUpdateProcessor';
