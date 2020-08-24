<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/instagram.class.php';
require_once dirname(dirname(__DIR__)) . '/socialmediasource.class.php';

class SocialMediaSourceInstagram extends SocialMediaSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Instagram';

    /**
     * @access public.
     * @param Array $credentials.
     */
    public function setSource(array $credentials = [])
    {
        $this->source = new Instagram($this->modx, $credentials);
    }

    /**
     * @access public.
     * @param String $criteria.
     * @param Array $credentials.
     * @param Integer $limit.
     * @return Array.
     */
    public function getData($criteria, array $credentials = [], $limit = 10)
    {
        $source = $this->getSource($credentials);

        if ($source) {
            if (strpos($criteria, '@') === 0) {
                if (strpos($criteria, '@ID:') === 0) {
                    $criteria = trim(substr($criteria, 4));
                } else if (strpos($criteria, '@USERNAME:') === 0) {
                    $criteria = trim(substr($criteria, 10));
                } else {
                    $criteria = substr($criteria, 1);
                }

                $parameters = [
                    'count' => $limit,
                    'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,username,timestamp'
                ];

                $responseMessages = $source->getApiData($criteria . '/media', $parameters);

                if ((int) $responseMessages['code'] === 200) {
                    if (isset($responseMessages['data']['data'])) {
                        $output = [];

                        foreach ((array) $responseMessages['data']['data'] as $message) {
                            $output[] = $this->getFormat($message);
                        }

                        return $this->setResponse($responseMessages['code'], $this->getDataSort($output));
                    }
                }

                return $this->setResponse($responseMessages['code'], $responseMessages['message']);
            }

            /*
            if (strpos($criteria, '#') === 0) {
                $criteria = substr($criteria, 1);

                $parameters = [
                    'count' => $limit
                ];

                $responseMessages = $source->getApiData('tags/' . $criteria . '/media/recent', $parameters);

                if ((int) $responseMessages['code'] === 200) {
                    if (isset($responseMessages['data']['data'])) {
                        $output = [];

                        foreach ((array) $responseMessages['data']['data'] as $message) {
                            $output[] = $this->getFormat($message);
                        }

                        return $this->setResponse($responseMessages['code'], $this->getDataSort($output));
                    }
                }

                return $this->setResponse($responseMessages['code'], $responseMessages['message']);
            }
            */

            return $this->setResponse(500, 'API criteria method not supported.');
        }

        return $this->setResponse(500, 'API credentials not supported.');
    }

    /**
     * @access private.
     * @param Array $data.
     * @return Array.
     */
    private function getFormat(array $data = [])
    {
        $userName   = $data['username'];
        $userImage  = '';
        $content    = '';
        $image      = '';
        $video      = '';
        $likes      = 0;
        $comments   = 0;

        if (isset($data['caption'])) {
            $content = $data['caption'];
        }

        switch ($data['media_type']) {
            case 'IMAGE':
            case 'CAROUSEL_ALBUM':
                $image = str_replace(['https:', 'http:'], '', $data['media_url']);
                break;
            case 'VIDEO':
                $video = str_replace(['https:', 'http:'], '', $value['media_url']);
                break;
        }

        return [
            'key'           => $data['id'],
            'source'        => strtolower($this->getName()),
            'user_name'     => $this->getEmojiFormat($userName),
            'user_account'  => $this->getEmojiFormat($data['username']),
            'user_image'    => $this->getImageFormat($userImage),
            'user_url'      => 'https://www.instagram.com/' . $data['username'],
            'content'       => $this->getEmojiFormat($content),
            'image'         => $this->getImageFormat($image),
            'video'         => $video,
            'url'           => $data['permalink'],
            'likes'         => $likes,
            'comments'      => $comments,
            'created'       => date('Y-m-d H:i:s', $data['timestamp'])
        ];
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getHtmlFormat($content)
    {
        $content = preg_replace('/@(\w+)/', '<a href="https://www.instagram.com/\\1" target="_blank">@\\1</a>', $content);
        $content = preg_replace('/#(\w+)/', '<a href="https://www.instagram.com/explore/tags/\\1" target="_blank">#\\1</a>', $content);

        return parent::getHtmlFormat($content);
    }
}
