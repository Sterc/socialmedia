<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaSourcesGetListProcessor extends modProcessor
{
    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['socialmedia:default'];

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'socialmedia.source';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path').'components/socialmedia/') . 'model/socialmedia/');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Array.
     */
    public function process()
    {
        return $this->outputArray(array_values($this->modx->socialmedia->getAvailableSources()));
    }
}

return 'SocialMediaSourcesGetListProcessor';
