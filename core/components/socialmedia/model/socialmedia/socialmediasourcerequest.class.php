<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaSourceRequest
{
    /**
     * @access public.
     * @var modX.
     */
    public $modx;

    /**
     * @access protected.
     * @var String.
     */
    public $name = '';

    /**
     * @access public.
     * @var Array.
     */
    public $credentials = [];

    /**
     * @access protected.
     * @var Array.
     */
    protected $response = [];

    /**
     * @access public.
     * @param modX $modx.
     * @param Array $credentials.
     */
    public function __construct(modX &$modx, array $credentials = [])
    {
        $this->modx =& $modx;
        $this->credentials = $credentials;
    }

    /**
     * @access public.
     * @return String.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @access public.
     * @param Array $credentials.
     */
    public function setCredentials(array $credentials = [])
    {
        $this->credentials = $credentials;
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @access public.
     * @param String $key.
     * @return String.
     */
    public function getCredential($key)
    {
        if (isset($this->credentials[$key])) {
            return $this->credentials[$key];
        }

        return null;
    }

    /**
     * @access public.
     * @param String $endpoint.
     * @param Array $parameters.
     * @param String $method.
     * @param Array $options.
     * @return Mixed.
     */
    public function makeApiRequest($endpoint, array $parameters = [], $method = 'GET', array $options = [])
    {
        $options += [
            CURLOPT_HEADER          => false,
            CURLOPT_USERAGENT       => 'SocialMediaApi 1.0',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 10
        ];

        if (strtoupper($method) === 'POST') {
            $options = [
               CURLOPT_URL          => $endpoint,
               CURLOPT_POSTFIELDS   => http_build_query($parameters)
           ] + $options;
        } else {
            $options = [
                CURLOPT_URL         => $endpoint . '?' . http_build_query($parameters)
            ] + $options;
        }

        $curl = curl_init();

        curl_setopt_array($curl, $options);

        $response       = curl_exec($curl);
        $responseInfo   = curl_getinfo($curl);

        curl_close($curl);

        if (!isset($responseInfo['http_code']) || (int) $responseInfo['http_code'] !== 200) {
            $reponseError = json_decode($response, true);

            if ($reponseError) {
                if (isset($reponseError['message'])) {
                    return $this->setResponse($responseInfo['http_code'], $reponseError['message']);
                }

                if (isset($reponseError['error']['message'])) {
                    return $this->setResponse($responseInfo['http_code'], $reponseError['error']['message']);
                }

                if (isset($reponseError['errors'][0]['message'])) {
                    return $this->setResponse($responseInfo['http_code'], $reponseError['errors'][0]['message']);
                }

                if (isset($reponseError['error_description'])) {
                    return $this->setResponse($responseInfo['http_code'], $reponseError['error_description']);
                }

                if (isset($reponseError['meta']['error_message'])) {
                    return $this->setResponse($responseInfo['http_code'], $reponseError['meta']['error_message']);
                }
            }

            return $this->setResponse($responseInfo['http_code'], 'API returned incorrect HTTP code.');
        }
        
        $output = json_decode($response, true);
        if (isset($output['paging']['next'])) {
            $parts = explode('?', $output['paging']['next']);
            if (count($parts) == 2) {
                $endpoint = array_shift($parts);
                parse_str(array_pop($parts), $parameters);
                $next = $this->makeApiRequest($endpoint, $parameters);
                if (isset($next['code']) && (int) $next['code'] == 200) {
                    $output['data'] = array_merge($output['data'], $next['data']['data']);
                }
            }
        }
        return $this->setResponse(200, $output);
    }

    /**
     * @access public.
     * @param String $source.
     * @param String $destination.
     * @return Mixed.
     */
    public function makeImageRequest($source, $destination)
    {
        $basePath = rtrim($this->modx->getOption('base_path', null, MODX_BASE_PATH), '/');

        if (strpos($source, '//') === 0) {
            $source = substr($source, 2);
        }

        if (file_exists($basePath . $destination)) {
            return $this->setResponse(200, $destination);
        }

        if (!file_exists($basePath . $destination)) {
            $file = fopen($basePath . $destination, 'wb');

            if ($file) {
                $curl = curl_init($source);

                curl_setopt_array($curl, [
                    CURLOPT_FILE            => $file,
                    CURLOPT_HEADER          => 0,
                    CURLOPT_FOLLOWLOCATION  => true
                ]);

                $response       = curl_exec($curl);
                $responseInfo   = curl_getinfo($curl);

                curl_close($curl);

                fclose($file);

                if (!isset($responseInfo['http_code']) || (int) $responseInfo['http_code'] !== 200) {
                    return $this->setResponse(400, 'Image returned incorrect HTTP code.');
                }

                return $this->setResponse(200, $destination);
            }
        }

        return $this->setResponse(400, 'Image returned incorrect HTTP code.');
    }

    /**
     * @access public.
     * @param Integer $code.
     * @param Array|String $data.
     * @return Array.
     */
    public function setResponse($code, $data)
    {
        if ((int) $code === 200) {
            $this->response = [
                'code'      => (int) $code,
                'data'      => $data
            ];
        } else {
            $this->response = [
                'code'      => (int) $code,
                'message'   => $data
            ];
        }

        return $this->response;
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function hasResponseError()
    {
        return isset($this->response['code']) && $this->response['code'] !== 200;
    }
}
