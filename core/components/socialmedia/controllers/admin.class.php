<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(__DIR__) . '/index.class.php';

class SocialMediaAdminManagerController extends SocialMediaManagerController
{
    /**
     * @access public.
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/widgets/admin.panel.js');

        $this->addJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/widgets/criteria.grid.js');

        $this->addLastJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/sections/admin.js');
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
        return $this->modx->socialmedia->config['templates_path'] . 'admin.tpl';
    }

    /**
     * @access public.
     * @returns Boolean.
     */
    public function checkPermissions()
    {
        return $this->modx->hasPermission('socialmedia_admin');
    }
}
