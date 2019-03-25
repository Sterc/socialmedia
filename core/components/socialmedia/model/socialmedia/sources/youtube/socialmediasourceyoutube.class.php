<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/youtube.class.php';
require_once dirname(dirname(__DIR__)) . '/socialmediasource.class.php';

class SocialMediaSourceYoutube extends SocialMediaSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'Youtube';

    /**
     * @access public.
     */
    public function setSource()
    {
        $this->source = new Youtube($this->modx);
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
            $parameters = [];

            if (in_array($criteria, ['@me', '@self'], true)) {
                $parameters['mine'] = 'true';
            } else if (strpos($criteria, '@ID:') === 0) {
                $parameters['id'] = trim(substr($criteria, 4));
            } else if (strpos($criteria, '@USERNAME:') === 0) {
                $parameters['forUsername'] = trim(substr($criteria, 10));
            } else {
                $parameters['forUsername'] = substr($criteria, 1);
            }

            $parameters = array_merge($parameters, [
                'part' => 'snippet,contentDetails,status'
            ]);

            $responseAccount = $this->getSource()->makeRequest('channels', $parameters);

            if ((int) $responseAccount['code'] === 200) {
                if (isset($responseAccount['data']['items'])) {
                    $output = [];

                    foreach ((array) $responseAccount['data']['items'] as $channel) {
                        if (isset($channel['contentDetails']['relatedPlaylists']['uploads'])) {
                            $parameters = [
                                'playlistId'    => $channel['contentDetails']['relatedPlaylists']['uploads'],
                                'part'          => 'snippet,contentDetails,status'
                            ];

                            $responseMessages = $this->getSource()->makeRequest('playlistItems', $parameters);

                            if ((int) $responseMessages['code'] === 200) {
                                foreach ((array) $responseMessages['data']['items'] as $data) {
                                    $output[] = $this->getFormat($data, $channel);
                                }
                            }
                        }
                    }

                    return $this->setResponse($responseAccount['code'], $this->getDataSort($output));
                }
            }

            return $this->setResponse($responseAccount['code'], $responseAccount['message']);
        }

        if (strpos($criteria, '#') === 0) {
            $parameters = [
                'q'             => substr($criteria, 1),
                'part'          => 'snippet',
                'maxResults'    => $limit,
                'type'          => 'video'
            ];

            $responseMessage = $this->getSource()->makeRequest('search', $parameters);

            if ((int) $responseMessage['code'] === 200) {
                if (isset($responseMessage['data']['items'])) {
                    $output = [];

                    foreach ((array) $responseMessage['data']['items'] as $message) {
                        if (isset($message['snippet']['channelId'])) {
                            $parameters = [
                                'id'    => $message['snippet']['channelId'],
                                'part'  => 'snippet,contentDetails,status'
                            ];

                            $responseAccount = $this->getSource()->makeRequest('channels', $parameters);

                            if ((int) $responseAccount['code'] === 200) {
                                foreach ((array) $responseAccount['data']['items'] as $data) {
                                    $output[] = $this->getFormat($message, $data);
                                }
                            }
                        }
                    }

                    return $this->setResponse($responseMessage['code'], $this->getDataSort($output));
                }
            }

            return $this->setResponse($responseMessage['code'], $responseMessage['message']);

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
        if (isset($data['snippet'])) {
            $userName       = '';
            $userAccount    = '';
            $userImage      = '';
            $userUrl        = '';

            $id             = '';
            $content        = '';
            $image          = '';

            if (isset($data['id']['videoId'])) {
                $id = $data['id']['videoId'];
            } else {
                $id = $data['snippet']['resourceId']['videoId'];
            }

            if (isset($account['snippet'])) {
                $userName = $account['snippet']['title'];

                if (isset($account['snippet']['customUrl'])) {
                    $userAccount    = $account['snippet']['customUrl'];
                    $userUrl        = 'https://www.youtube.com/' . $account['snippet']['customUrl'];
                } else {
                    $userAccount    = $account['snippet']['title'];
                    $userUrl        = 'https://www.youtube.com/channel/' . $account['id'];
                }

                foreach ((array) $account['snippet']['thumbnails'] as $thumbnail) {
                    $userImage = str_replace(['https:', 'http:'], '', $thumbnail['url']);
                }
            }

            if (isset($data['snippet']['description']) && !empty($data['snippet']['description'])) {
                $content = $data['snippet']['description'];
            } else if (isset($data['snippet']['title'])) {
                $content = $data['snippet']['title'];
            }

            if (isset($data['snippet']['thumbnails'])) {
                foreach ((array) $data['snippet']['thumbnails'] as $media) {
                    $image = str_replace(['https:', 'http:'], '', $media['url']);
                }
            }

            return [
                'key'       => $id,
                'source'        => strtolower($this->getName()),
                'user_name'     => $this->getEmojiFormat($userName),
                'user_account'  => $this->getEmojiFormat($userAccount),
                'user_image'    => $userImage,
                'user_url'      => $userUrl,
                'content'       => $this->getEmojiFormat($content),
                'image'         => $image,
                'video'         => 'https://www.youtube.com/watch?v=' . $id,
                'url'           => 'https://www.youtube.com/watch?v=' . $id,
                'created'       => date('Y-m-d H:i:s', strtotime($data['snippet']['publishedAt']))
            ];
        }
    }

    /**
     * @access public.
     * @param String $content.
     * @return String.
     */
    public function getHtmlFormat($content)
    {
        $content = preg_replace('/@(\w+)/', '<a href="https://www.youtube.com/user/\\1" target="_blank">@\\1</a>', $content);
        $content = preg_replace('/#(\w+)/', '<a href="https://www.youtube.com/results?search_query=\\1" target="_blank">#\\1</a>', $content);

        return parent::getHtmlFormat($content);
    }
}
