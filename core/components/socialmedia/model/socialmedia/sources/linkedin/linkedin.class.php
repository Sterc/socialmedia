<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(__DIR__)) . '/socialmediasourcerequest.class.php';

class LinkedIn extends SocialMediaSourceRequest
{
    const API_URL = 'https://api.linkedin.com/v1/';

    /**
     * @access public.
     * @return String.
     */
    public function getApiKey()
    {
        return $this->modx->getOption('socialmedia.source_linkedin_client_id');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiSecret()
    {
        return $this->modx->getOption('socialmedia.source_linkedin_client_secret');
    }

    /**
     * @access public.
     * @return String.
     */
    public function getApiAccessToken()
    {
        return $this->modx->getOption('socialmedia.source_linkedin_access_token');
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
            $endpoint = rtrim(LinkedIn::API_URL, '/') . '/' . rtrim($endpoint, '/') . '/';
        }

        $parameters = array_merge($parameters, [
            'oauth2_access_token'   => $this->getApiAccessToken(),
            'format'                => 'json'
        ]);

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }
}
