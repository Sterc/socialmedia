<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(__DIR__)) . '/socialmediasourcerequest.class.php';

class Twitter extends SocialMediaSourceRequest
{
    const API_URL = 'https://api.twitter.com/1.1/';

    /**
     * @access private.
     * @return String.
     */
    private function getConsumerKey()
    {
        return $this->modx->getOption('socialmedia.source_twitter_consumer_key');
    }

    /**
     * @access private.
     * @return String.
     */
    private function getConsumerKeySecret()
    {
        return $this->modx->getOption('socialmedia.source_twitter_consumer_key_secret');
    }

    /**
    * @access private.
    * @return String.
    */
    private function getAccesToken()
    {
        return $this->modx->getOption('socialmedia.source_twitter_access_token');
    }

    /**
     * @access private.
     * @return String.
     */
    private function getAccesTokenSecret()
    {
        return $this->modx->getOption('socialmedia.source_twitter_access_token_secret');
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
            $endpoint = rtrim(Twitter::API_URL, '/') . '/' . rtrim($endpoint, '/') . '.json';
        }

        $options = [
            CURLOPT_HTTPHEADER => [
                $this->buildAuthorizationHeader($this->buildOAuth($endpoint, $method, $parameters)),
                'Expect:'
            ]
        ] + $options;

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }

    /**
     * @access public.
     * @param String $endpoint.
     * @param String $method.
     * @param Array $parameters.
     * @return Array.
     */
    private function buildOAuth($endpoint, $method, array $parameters = [])
    {
        $oauth = [
            'oauth_consumer_key'        => $this->getConsumerKey(),
            'oauth_nonce'               => time(),
            'oauth_signature_method'    => 'HMAC-SHA1',
            'oauth_token'               => $this->getAccesToken(),
            'oauth_timestamp'           => time(),
            'oauth_version'             => '1.0'
        ];

        foreach ($parameters as $key => $parameter) {
            if (!in_array($key, $oauth, true)) {
                $oauth[$key] = $parameter;
            }
        }

        $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $this->buildOAuthString($endpoint, $method, $oauth), rawurlencode($this->getConsumerKeySecret()) . '&' . rawurlencode($this->getAccesTokenSecret()), true));

        return $oauth;
    }

    /**
     * @access private.
     * @param String $endpoint.
     * @param String $method.
     * @param Array $parameters.
     * @return String.
     */
    private function buildOAuthString($endpoint, $method, array $parameters = [])
    {
        $output = [];

        ksort($parameters);

        foreach($parameters as $key => $value) {
            $output[] = rawurlencode($key).'='.rawurlencode($value);
        }

        return $method . '&' . rawurlencode($endpoint) . '&' . rawurlencode(implode('&', $output));
    }

    /**
     * @access private.
     * @param Array $oauth.
     * @return String.
     */
    private function buildAuthorizationHeader($oauth)
    {
        $output = [];

        foreach($oauth as $key => $value) {
            if (in_array($key, ['oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp', 'oauth_token', 'oauth_version'], true)) {
                $output[] = $key . '="' . rawurlencode($value) . '"';
            }
        }

        return 'Authorization: OAuth ' . implode(', ', $output);
    }
}
