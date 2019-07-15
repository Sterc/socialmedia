<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/facebook.class.php';
require_once dirname(dirname(__DIR__)) . '/socialmediasource.class.php';

class SocialMediaSourceFacebook extends SocialMediaSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Facebook';

    /**
     * @access public.
     */
    public function setSource()
    {
        $this->source = new Facebook($this->modx);
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
                'fields' => 'id,name,link,picture.width(500).height(500)'
            ];

            $responseAccount = $this->getSource()->makeRequest($criteria, $parameters);

            if ((int) $responseAccount['code'] === 200) {
                $parameters = [
                    'fields'    => 'id,from,message,created_time,full_picture,permalink_url,type,link,shares,comments.summary(true),likes.summary(true)',
                    'limit'     => $limit
                ];

                $responseMessages = $this->getSource()->makeRequest($criteria . '/posts', $parameters);

                if ((int) $responseMessages['code'] === 200) {
                    $output = [];

                    foreach ((array) $responseMessages['data']['data'] as $data) {
                        $output[] = $this->getFormat($data, $responseAccount['data']);
                    }

                    return $this->setResponse($responseMessages['code'], $this->getDataSort($output));
                }

                return $this->setResponse($responseMessages['code'], $responseMessages['message']);
            }

            return $this->setResponse($responseAccount['code'], $responseAccount['message']);
        }

        if (strpos($criteria, '#') === 0) {
            return $this->setResponse(500, 'API criteria method not supported.');
        }

        return $this->setResponse(500, 'API criteria method not supported.');
    }

    /**
     * @access private.
     * @param Array $data.
     * @param Array $account.
     * @return Array.
     */
    private function getFormat(array $data = [], array $account = [])
    {
        $userImage  = '';
        $content    = '';
        $image      = '';
        $video      = '';
        $likes      = 0;
        $comments   = 0;

        if (isset($account['picture']['data']['url'])) {
            $userImage = str_replace(['https:', 'http:'], '', $account['picture']['data']['url']);
        }

        if (isset($data['message'])) {
            $content = $data['message'];
        }

        if ($data['type'] === 'video' || $data['type'] === 'photo') {
            $image = str_replace(['https:', 'http:'], '', $data['full_picture']);
        }

        if ($data['type'] === 'video') {
            $video = str_replace(['https:', 'http:'], '', $data['link']);
        }

        if (isset($data['likes']['summary']['total_count'])) {
            $likes = (int) $data['likes']['summary']['total_count'];
        }

        if (isset($data['comments']['summary']['total_count'])) {
            $comments = (int) $data['comments']['summary']['total_count'];
        }

        return [
            'key'           => $data['id'],
            'source'        => strtolower($this->getName()),
            'user_name'     => $this->getEmojiFormat($account['name']),
            'user_account'  => '',
            'user_image'    => $this->getImageFormat($userImage),
            'user_url'      => '',
            'content'       => $this->getEmojiFormat($content),
            'image'         => $this->getImageFormat($image),
            'video'         => $video,
            'url'           => $data['permalink_url'],
            'likes'         => $likes,
            'comments'      => $comments,
            'created'       => date('Y-m-d H:i:s', strtotime($data['created_time']))
        ];
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getHtmlFormat($content)
    {
        $content = preg_replace('/#(\w+)/', '<a href="https://www.facebook.com/hashtag/\\1" target="_blank">#\\1</a>', $content);

        return parent::getHtmlFormat($content);
    }
}
