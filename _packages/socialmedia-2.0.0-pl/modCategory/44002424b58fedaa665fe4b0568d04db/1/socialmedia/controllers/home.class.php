<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(__DIR__) . '/index.class.php';

class SocialMediaHomeManagerController extends SocialMediaManagerController
{
    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/widgets/home.panel.js');

        $this->addJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/widgets/messages.grid.js');

        $this->addLastJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/sections/home.js');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('socialmedia');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getTemplateFile()
    {
        return $this->modx->socialmedia->config['templates_path'] . 'home.tpl';
    }
}
