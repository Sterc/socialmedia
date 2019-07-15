<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/pinterest.class.php';
require_once dirname(dirname(__DIR__)) . '/socialmediasource.class.php';

class SocialMediaSourcePinterest extends SocialMediaSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Pinterest';

    /**
     * @access public.
     */
    public function setSource()
    {
        $this->source = new Pinterest($this->modx);
    }

    /**
     * @access public.
     * @param String $criteria.
     * @param Integer $limit.
     * @return Array.
     */
    public function getData($criteria, $limit = 10)
    {
        if (strpos($criteria, '@') === 0) {
            if (in_array($criteria, ['@me', '@self'], true)) {
                $criteria = 'me';
            } else if (strpos($criteria, '@ID:') === 0) {
                $criteria = trim(substr($criteria, 4));
            } else if (strpos($criteria, '@USERNAME:') === 0) {
                $criteria = trim(substr($criteria, 10));
            } else {
                $criteria = substr($criteria, 1);
            }

            $parameters = [
                'limit'     => $limit,
                'fields'    => 'id,link,creator(id,first_name,last_name,url,image[236x],username),image,note,created_at'
            ];

            $responseMessages = $this->getSource()->makeRequest('me/pins/', $parameters);

            if ((int) $responseMessages['code'] === 200) {
                $output = [];

                foreach ((array) $responseMessages['data']['data'] as $data) {
                    $output[] = $this->getFormat($data);
                }

                return $this->setResponse($responseMessages['code'], $this->getDataSort($output));
            }

            return $this->setResponse($responseMessages['code'], $responseMessages['message']);
        }

        if (strpos($criteria, '#') === 0) {
            $parameters = [
                'limit'     => $limit,
                'query'     => substr($criteria, 1),
                'fields'    => 'id,link,creator(id,first_name,last_name,url,image[236x],username),image,note,created_at'
            ];

            $responseMessages = $this->getSource()->makeRequest('me/search/pins/', $parameters);

            if ((int) $responseMessages['code'] === 200) {
                $output = [];

                foreach ((array) $responseMessages['data']['data'] as $data) {
                    $output[] = $this->getFormat($data);
                }

                return $this->setResponse($responseMessages['code'], $this->getDataSort($output));
            }

            return $this->setResponse($responseMessages['code'], $responseMessages['message']);
        }

        return $this->setResponse(500, 'API criteria method not supported.');
    }

    /**
     * @access private.
     * @param Array $data.
     * @return Array.
     */
    private function getFormat(array $data = [])
    {
        $userImage  = '';
        $content    = '';
        $image      = '';
        $video      = '';

        if (isset($data['creator']['image'])) {
            foreach ((array) $data['creator']['image'] as $value) {
                $userImage = str_replace(['https:', 'http:'], '', $value['url']);
            }
        }

        if (isset($data['note'])) {
            $content = $data['note'];
        }

        if (isset($data['image'])) {
            if (isset($data['image']['original'])) {
                $image = str_replace(['https:', 'http:'], '', $data['image']['original']['url']);
            } else {
                foreach ((array) $data['image'] as $value) {
                    $image = str_replace(['https:', 'http:'], '', $value['url']);
                }
            }
        }

        return [
            'key'           => $data['id'],
            'source'        => strtolower($this->getName()),
            'user_name'     => $this->getEmojiFormat($data['creator']['first_name'] . ' ' . $data['creator']['last_name']),
            'user_account'  => $this->getEmojiFormat($data['creator']['username']),
            'user_image'    => $this->getImageFormat($userImage),
            'user_url'      => 'https://www.pinterest.com/' . $data['creator']['username'],
            'content'       => $this->getEmojiFormat($content),
            'image'         => $this->getImageFormat($image),
            'video'         => $video,
            'url'           => 'https://www.pinterest.com/pin/' . $data['id'],
            'created'       => date('Y-m-d H:i:s', strtotime($data['created_at']))
        ];
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getHtmlFormat($content)
    {
        $content = preg_replace('/@(\w+)/', '<a href="https://www.pinterest.com/\\1" target="_blank">@\\1</a>', $content);
        $content = preg_replace('/#(\w+)/', '<a href="https://www.pinterest.com/search/pins/?q=\\1" target="_blank">#\\1</a>', $content);

        return parent::getHtmlFormat($content);
    }
}
