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
     * @return String.
     */
    public function process()
    {
        $output = [];

        foreach ((array) $this->modx->socialmedia->getAvailableSources(true) as $source) {
            $output[] = [
                'type'      => strtolower($source->getName()),
                'label'     => $source->getName(),
                'fields'    => $source->getFields()
            ];
        }

        return $this->outputArray($output);
    }
}

return 'SocialMediaSourcesGetListProcessor';
