<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(__DIR__)) . '/socialmediasourcerequest.class.php';

class Youtube extends SocialMediaSourceRequest
{
    const API_URL   = 'https://www.googleapis.com/youtube/v3/';
    const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    /**
     * @access public.
     * @return Array.
     */
    public function getApiFields()
    {
        return [
            [
                'name'          => 'client_id',
                'label'         => $this->modx->lexicon('socialmedia.label_youtube_client_id'),
                'description'   => $this->modx->lexicon('socialmedia.label_youtube_client_id_desc'),
            ], [
                'name'          => 'client_secret',
                'label'         => $this->modx->lexicon('socialmedia.label_youtube_client_secret'),
                'description'   => $this->modx->lexicon('socialmedia.label_youtube_client_secret_desc'),
            ], [
                'name'          => 'refresh_token',
                'label'         => $this->modx->lexicon('socialmedia.label_youtube_refresh_token'),
                'description'   => $this->modx->lexicon('socialmedia.label_youtube_refresh_token_desc'),
            ]
        ];
    }

    /**
     * @access public.
     * @param String $endpoint.
     * @param Array $parameters.
     * @param String $method.
     * @param Array $options.
     * @return Array.
     */
    public function getApiData($endpoint, array $parameters = [], $method = 'GET', array $options = [])
    {
        if (strpos($endpoint, 'https://') !== 0 && strpos($endpoint, 'http://') !== 0) {
            $endpoint = rtrim(Youtube::API_URL, '/') . '/' . rtrim($endpoint, '/') . '/';
        }

        $parameters = array_merge($parameters, [
            'access_token' => $this->getApiRefreshAccessToken()
        ]);

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiRefreshAccessToken() {
        $parameters = [
            'refresh_token'     => $this->getCredential('refresh_token'),
            'client_id'         => $this->getCredential('client_id'),
            'client_secret'     => $this->getCredential('client_secret'),
            'grant_type'        => 'refresh_token'
        ];

        $token = $this->makeApiRequest(Youtube::TOKEN_URL, $parameters, 'POST');

        if ($token) {
            if (isset($token['data']['access_token'])) {
                return $token['data']['access_token'];
            }
        }

        return false;
    }
}
