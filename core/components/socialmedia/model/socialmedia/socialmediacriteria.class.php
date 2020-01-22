<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaCriteria extends xPDOSimpleObject
{
    /**
     * @access public.
     * @return Array.
     */
    public function getCredentials()
    {
        $credentials = json_decode($this->get('credentials'), true);

        if ($credentials) {
            return $credentials;
        }

        return [];
    }
}
