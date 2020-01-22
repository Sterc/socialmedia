<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaSource
{
    /**
     * @access public.
     * @var modX.
     */
    public $modx;

    /**
     * @access protected.
     * @var Object.
     */
    protected $source;

    /**
     * @access protected.
     * @var Array.
     */
    protected $response = [];

    /**
     * @access public.
     * @param modX $modx.
     */
    public function __construct(modX &$modx)
    {
        $this->modx =& $modx;
    }

    /**
     * @access public.
     * @return String.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @access public.
     * @param Array $credentials,
     * @return Object.
     */
    public function getSource(array $credentials = [])
    {
        if (null === $this->source) {
            $this->setSource($credentials);
        }

        return $this->source;
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getFields()
    {
        $source = $this->getSource();

        if (method_exists($source, 'getApiFields')) {
            return $source->getApiFields();
        }

        return [];
    }

    /**
     * @access public.
     * @param Integer $code.
     * @param Array|String $data.
     * @return Array.
     */
    public function setResponse($code, $data)
    {
        if ((int) $code === 200) {
            $this->response = [
                'code'      => (int) $code,
                'data'      => $data
            ];
        } else {
            $this->response = [
                'code'      => (int) $code,
                'message'   => $data
            ];
        }

        return $this->response;
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function hasResponseError()
    {
        return isset($this->response['code']) && $this->response['code'] !== 200;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function showEmptyPosts()
    {
        return (bool) $this->modx->getOption('socialmedia.source_' . strtolower($this->getName()) . '_empty_posts', null, false);
    }

    /**
     * @access public.
     * @param Array $data.
     * @return Array.
     */
    public function getDataSort(array $data = [])
    {
        $sort = [];

        foreach ($data as $key => $value) {
            $sort[$key] = strtotime($value['created']);
        }

        array_multisort($sort, SORT_DESC, $data);

        return $data;
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getHtmlFormat($content) {
        $content = preg_replace('#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#', '\\1<a href="\\2" target="_blank">\\2</a>', $content);
        $content = preg_replace('#(^|[\n ])((http|www|ftp)\.[^ \"\t\n\r< ]*)#', '\\1<a href="http://\\2" target="_blank">\\2</a>', $content);

        $content = nl2br($content);
        //$content = trim(preg_replace('/\s+/', ' ', trim($content)));

        return $content;
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getEmojiFormat($content)
    {
        if ((bool) $this->modx->getOption('socialmedia.remove_emoji')) {
            $replaceCharacters = '/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}';
            $replaceCharacters .= '|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|';
            $replaceCharacters .= '\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?';
            $replaceCharacters .= '|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?';
            $replaceCharacters .= '|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?';
            $replaceCharacters .= '|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?';
            $replaceCharacters .= '|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u';

            return preg_replace($replaceCharacters, '', $content);
        }

        return $content;
    }

    /**
     * @access public.
     * @param String $url.
     * @return Boolean|String.
     */
    public function getImageFormat($url)
    {
        if (!(bool) $this->modx->getOption('socialmedia.image_path', null, true)) {
            return $url;
        }

        $image = $url;

        if (strrpos($image, '?') !== false) {
            $image = substr($image, 0, strrpos($image, '?'));
        }

        $name = strtolower(substr($image, strrpos($image, '/') + 1));

        if (preg_match('/asid\=([A-Za-z0-9\-\_]+)/si', $url, $matches)) {
            $name = $matches[1] . '.jpeg';
        }

        if (empty($name)) {
            return $url;
        }

        $location =  '/' . trim($this->modx->getOption('socialmedia.image_path'), '/') . '/' . ltrim($name, '/');

        $response = $this->getSource()->makeImageRequest($url, $location);

        if ((int) $response['code'] === 200) {
            return $response['data'];
        }

        return $url;
    }
}
