<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMedia
{
    /**
     * @access public.
     * @var Object.
     */
    public $modx;

    /**
     * @access public.
     * @var Array.
     */
    public $config = [];

    /**
     * @access public.
     * @param modX $modx.
     * @param Array $config.
     */
    public function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath   = $this->modx->getOption('socialmedia.core_path', $config, $this->modx->getOption('core_path') . 'components/socialmedia/');
        $assetsUrl  = $this->modx->getOption('socialmedia.assets_url', $config, $this->modx->getOption('assets_url') . 'components/socialmedia/');
        $assetsPath = $this->modx->getOption('socialmedia.assets_path', $config, $this->modx->getOption('assets_path') . 'components/socialmedia/');

        $this->config = array_merge([
            'namespace'             => 'socialmedia',
            'lexicons'              => ['socialmedia:default'],
            'base_path'             => $corePath,
            'core_path'             => $corePath,
            'model_path'            => $corePath . 'model/',
            'processors_path'       => $corePath . 'processors/',
            'elements_path'         => $corePath . 'elements/',
            'chunks_path'           => $corePath . 'elements/chunks/',
            'plugins_path'          => $corePath . 'elements/plugins/',
            'snippets_path'         => $corePath . 'elements/snippets/',
            'templates_path'        => $corePath . 'templates/',
            'assets_path'           => $assetsPath,
            'js_url'                => $assetsUrl . 'js/',
            'css_url'               => $assetsUrl . 'css/',
            'assets_url'            => $assetsUrl,
            'connector_url'         => $assetsUrl . 'connector.php',
            'version'               => '2.0.2',
            'branding_url'          => $this->modx->getOption('socialmedia.branding_url'),
            'branding_help_url'     => $this->modx->getOption('socialmedia.branding_url_help'),
            'cronjob'               => (bool) $this->modx->getOption('socialmedia.cronjob', null, false),
            'permissions'           => [
                'admin'                 => $this->modx->hasPermission('socialmedia_admin')
            ]
        ], $config);

        $this->modx->addPackage('socialmedia', $this->config['model_path']);

        if (is_array($this->config['lexicons'])) {
            foreach ($this->config['lexicons'] as $lexicon) {
                $this->modx->lexicon->load($lexicon);
            }
        } else {
            $this->modx->lexicon->load($this->config['lexicons']);
        }
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getHelpUrl()
    {
        $url = $this->getOption('branding_url_help');

        if (!empty($url)) {
            return $url . '?v=' . $this->config['version'];
        }

        return false;
    }

    /**
     * @access public.
     * @return String|Boolean.
     */
    public function getBrandingUrl()
    {
        $url = $this->getOption('branding_url');

        if (!empty($url)) {
            return $url;
        }

        return false;
    }

    /**
     * @access public.
     * @param String $key.
     * @param Array $options.
     * @param Mixed $default.
     * @return Mixed.
     */
    public function getOption($key, array $options = [], $default = null)
    {
        if (isset($options[$key])) {
            return $options[$key];
        }

        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return $this->modx->getOption($this->config['namespace'] . '.' . $key, $options, $default);
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getCriteria()
    {
        $output = [];

        $criteria = $this->modx->newQuery('SocialMediaCriteria', [
            'active' => 1
        ]);

        foreach ((array) $this->modx->getCollection('SocialMediaCriteria', $criteria) as $criteria) {
            $output[] = [
                'id'        => $criteria->get('id'),
                'source'    => $criteria->get('source'),
                'criteria'  => $criteria->get('criteria')
            ];
        }

        return $output;
    }
    /**
     * @access public.
     * @param Boolean $returnClasses.
     * @return Array.
     */
    public function getAvailableSources($returnClasses = false)
    {
        $sources = [];

        foreach (new DirectoryIterator($this->config['model_path'] . 'socialmedia/sources/') as $file) {
            $filename = trim($file->getFilename(), '/');

            if (!in_array($filename, ['.', '..'], true) && $file->isDir()) {
                if ($returnClasses) {
                    $class = $this->getSource($filename);

                    if ($class) {
                        $sources[$filename] = $class;
                    }
                } else {
                    $sources[$filename] = [
                        'type'  => $filename,
                        'label' => ucfirst($filename)
                    ];
                }
            }
        }

        return $sources;
    }

    /**
     * @access public.
     * @param String $source.
     * @return Null|Object.
     */
    public function getSource($source) {
        $class = 'SocialMediaSource' . ucfirst($source);

        if ($this->modx->loadClass($class, $this->config['model_path'] . 'socialmedia/sources/' . $source . '/', true, true)) {
            $instance = new $class($this->modx, $this);

            if ($instance instanceOf SocialMediaSource) {
                return $instance;
            }
        }

        return null;
    }
}
