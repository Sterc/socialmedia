<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(__DIR__)) . '/socialmediasourcerequest.class.php';

class Facebook extends SocialMediaSourceRequest
{
    const API_URL = 'https://graph.facebook.com/';

    /**
     * @access public.
     * @return String.
     */
    public function getApiKey()
    {
        return $this->modx->getOption('socialmedia.source_facebook_client_id');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiSecret()
    {
        return $this->modx->getOption('socialmedia.source_facebook_client_secret');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiAccessToken()
    {
        return $this->modx->getOption('socialmedia.source_facebook_access_token');
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
            $endpoint = rtrim(Facebook::API_URL, '/') . '/' . rtrim($endpoint, '/') . '/';
        }

        $parameters = array_merge($parameters, [
            'access_token' => $this->getApiAccessToken()
        ]);

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }
}