<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

abstract class SocialMediaManagerController extends modExtraManagerController
{
    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

        $this->addCss($this->modx->socialmedia->config['css_url'] . 'mgr/socialmedia.css');

        $this->addJavascript($this->modx->socialmedia->config['js_url'] . 'mgr/socialmedia.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.config.help_url = "' . $this->modx->socialmedia->getHelpUrl() . '";
                
                SocialMedia.config = ' . $this->modx->toJSON(array_merge($this->modx->socialmedia->config, [
                    'branding_url'          => $this->modx->socialmedia->getBrandingUrl(),
                    'branding_url_help'     => $this->modx->socialmedia->getHelpUrl()
                ])) . ';
            });
        </script>');

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getLanguageTopics()
    {
        return $this->modx->socialmedia->config['lexicons'];
    }

    /**
     * @access public.
     * @returns Boolean.
     */
    public function checkPermissions()
    {
        return $this->modx->hasPermission('socialmedia');
    }
}

class IndexManagerController extends SocialMediaManagerController
{
    /**
     * @access public.
     * @return String.
     */
    public static function getDefaultController() {
        return 'home';
    }
}
