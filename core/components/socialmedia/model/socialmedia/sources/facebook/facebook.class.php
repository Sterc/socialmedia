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
     * @return Array.
     */
    public function getApiFields()
    {
        return [
            [
                'name'          => 'client_id',
                'label'         => $this->modx->lexicon('socialmedia.label_facebook_client_id'),
                'description'   => $this->modx->lexicon('socialmedia.label_facebook_client_id_desc'),
            ], [
                'name'          => 'client_secret',
                'label'         => $this->modx->lexicon('socialmedia.label_facebook_client_secret'),
                'description'   => $this->modx->lexicon('socialmedia.label_facebook_client_secret_desc'),
            ], [
                'name'          => 'access_token',
                'label'         => $this->modx->lexicon('socialmedia.label_facebook_access_token'),
                'description'   => $this->modx->lexicon('socialmedia.label_facebook_access_token_desc'),
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
            $endpoint = rtrim(Facebook::API_URL, '/') . '/' . rtrim($endpoint, '/') . '/';
        }

        $parameters = array_merge($parameters, [
            'access_token' => $this->getCredential('access_token')
        ]);

        return $this->makeApiRequest($endpoint, $parameters, $method, $options);
    }
}