<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once __DIR__ . '/linkedin.class.php';
require_once dirname(dirname(__DIR__)) . '/socialmediasource.class.php';

class SocialMediaSourceLinkedin extends SocialMediaSource
{
    /**
     * @access public.
     * @var String.
     */
    public $name = 'LinkedIn';

    /**
     * @access public.
     */
    public function setSource()
    {
        $this->source = new Linkedin($this->modx);
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
                $criteria = '~';
            } else if (strpos($criteria, '@ID:') === 0) {
                $criteria = trim(substr($criteria, 4));
            } else if (strpos($criteria, '@USERNAME:') === 0) {
                $criteria = trim(substr($criteria, 10));
            } else {
                $criteria = substr($criteria, 1);
            }

            $responseAccount = $this->getSource()->makeRequest('companies/' . $criteria . ':(id,name,logo-url,universal-name)');

            //$responseAccount = $this->getSource()->makeRequest('people/' . $criteria . ':(id,email-address,first-name,last-name)');

            if ((int) $responseAccount['code'] === 200) {
                $parameters = [
                    'limit' => $limit
                ];

                $responseMessages = $this->getSource()->makeRequest('companies/' . $criteria . '/updates', $parameters);

                if ((int) $responseMessages['code'] === 200) {
                    $output = [];

                    foreach ((array) $responseMessages['data']['values'] as $data) {
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
        if (isset($data['updateContent']['companyStatusUpdate']['share'])) {
            $userImage  = '';
            $content    = '';
            $image      = '';
            $video      = '';
            $likes      = 0;
            $comments   = 0;

            if (isset($account['logoUrl'])) {
                $userImage = str_replace(['https:', 'http:'], '', $account['logoUrl']);
            }

            if (isset($data['updateContent']['companyStatusUpdate']['share']['comment'])) {
                $content = $data['updateContent']['companyStatusUpdate']['share']['comment'];
            }

            if (isset($data['updateContent']['companyStatusUpdate']['share']['content']['submittedUrl'])) {
                if (!isset($data['updateContent']['companyStatusUpdate']['share']['content']['title'])) {
                    $image = str_replace(['https:', 'http:'], '', $data['updateContent']['companyStatusUpdate']['share']['content']['submittedUrl']);
                }
            }

            $url = explode('-', $data['updateKey']);

            if (isset($data['likes']['_total'])) {
                $likes = (int) $data['likes']['_total'];
            }

            if (isset($data['updateComments']['_total'])) {
                $comments = (int) $data['updateComments']['_total'];
            }

            return [
                'key'           => $data['updateContent']['companyStatusUpdate']['share']['id'],
                'source'        => strtolower($this->getName()),
                'user_name'     => $this->getEmojiFormat($account['name']),
                'user_account'  => $this->getEmojiFormat($account['universalName']),
                'user_image'    => $this->getImageFormat($userImage),
                'user_url'      => 'https://www.linkedin.com/company-beta/' . $account['id'],
                'content'       => $this->getEmojiFormat($content),
                'image'         => $this->getImageFormat($image),
                'video'         => $video,
                'url'           => 'https://www.linkedin.com/hp/update/' . end($url),
                'likes'         => $likes,
                'comments'      => $comments,
                'created'       => date('Y-m-d H:i:s', $data['updateContent']['companyStatusUpdate']['share']['timestamp'] / 1000)
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
        $content = preg_replace('/#(\w+)/', '<a href="https://www.linkedin.com/search/results/index/?keywords=\\1" target="_blank">#\\1</a>', $content);

        return parent::getHtmlFormat($content);
    }
}
