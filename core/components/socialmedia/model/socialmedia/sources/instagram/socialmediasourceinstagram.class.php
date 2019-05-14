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
     */
    public function setSource() {
        $this->source = new Instagram($this->modx);
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
            if (strpos($criteria, '@ID:') === 0) {
                $criteria = trim(substr($criteria, 4));
            } else if (strpos($criteria, '@USERNAME:') === 0) {
                $criteria = trim(substr($criteria, 10));
            } else {
                $criteria = substr($criteria, 1);
            }

            $parameters = [
                'count' => $limit
            ];

            $responseMessages = $this->getSource()->makeRequest('users/' . $criteria . '/media/recent', $parameters);

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

        if (strpos($criteria, '#') === 0) {
            $criteria = substr($criteria, 1);

            $parameters = [
                'count' => $limit
            ];

            $responseMessages = $this->getSource()->makeRequest('tags/' . $criteria . '/media/recent', $parameters);

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

        return $this->setResponse(500, 'API criteria method not supported.');
    }

    /**
     * @access private.
     * @param Array $data.
     * @return Array.
     */
    private function getFormat(array $data = [])
    {
        $userName   = $data['user']['full_name'];
        $userImage  = '';
        $content    = '';
        $image      = '';
        $video      = '';
        $likes      = 0;
        $comments   = 0;

        if (empty($userName)) {
            $userName = $data['user']['username'];
        }

        if (isset($data['user']['profile_picture'])) {
            $userImage = str_replace(['https:', 'http:'], '', $data['user']['profile_picture']);
        }

        if (isset($data['caption']['text'])) {
            $content = $data['caption']['text'];
        }

        if (isset($data['images'])) {
            foreach ((array) $data['images'] as $value) {
                $image = str_replace(['https:', 'http:'], '', $value['url']);
            }
        }

        if (isset($data['videos'])) {
            foreach ((array) $data['videos'] as $value) {
                $video = str_replace(['https:', 'http:'], '', $value['url']);
            }
        }

        if (isset($data['likes']['count'])) {
            $likes = (int) $data['likes']['count'];
        }

        if (isset($data['comments']['count'])) {
            $comments = (int) $data['comments']['count'];
        }

        return [
            'key'           => $data['id'],
            'source'        => strtolower($this->getName()),
            'user_name'     => $this->getEmojiFormat($userName),
            'user_account'  => $this->getEmojiFormat($data['user']['username']),
            'user_image'    => $userImage,
            'user_url'      => 'https://www.instagram.com/' . $data['user']['username'],
            'content'       => $this->getEmojiFormat($content),
            'image'         => $image,
            'video'         => $video,
            'url'           => $data['link'],
            'likes'         => $likes,
            'comments'      => $comments,
            'created'       => date('Y-m-d H:i:s', $data['created_time'])
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
