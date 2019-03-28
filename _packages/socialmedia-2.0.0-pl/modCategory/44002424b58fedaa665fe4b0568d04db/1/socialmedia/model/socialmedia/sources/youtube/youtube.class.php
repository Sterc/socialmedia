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
     * @return String.
     */
    public function getApiKey()
    {
        return $this->modx->getOption('socialmedia.source_youtube_client_id');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiSecret()
    {
        return $this->modx->getOption('socialmedia.source_youtube_client_secret');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiAccessToken()
    {
        return $this->getApiRefreshAccessToken();
    }

    /**
     * @access public.
     * @param String $endpoint.
     * @param Array $parameters.
     * @param String $method.
     * @param Array $options.
     * @return Array.
     */
    public function makeRequest($endpoint, array $parameters = [], $method = 'GET', array $options = [])
    {
        if (strpos($endpoint, 'https://') !== 0 && strpos($endpoint, 'http://') !== 0) {
            $endpoint = rtrim(Youtube::API_URL, '/') . '/' . rtrim($endpoint, '/') . '/';
        }

        $parameters = array_merge($parameters, [
            'access_token' => $this->getApiAccessToken()
        ]);

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiRefreshAccessToken() {
        $parameters = [
            'refresh_token'     => $this->modx->getOption('socialmedia.source_youtube_refresh_token'),
            'client_id'         => $this->getApiKey(),
            'client_secret'     => $this->getApiSecret(),
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
