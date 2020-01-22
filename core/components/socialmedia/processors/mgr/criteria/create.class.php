<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

class SocialMediaCriteriaCreateProcessor extends modObjectCreateProcessor
{
    /**
     * @access public.
     * @var String.
     */
    public $classKey = 'SocialMediaCriteria';

    /**
     * @access public.
     * @var Array.
     */
    public $languageTopics = ['socialmedia:default'];

    /**
     * @access public.
     * @var String.
     */
    public $objectType = 'socialmedia.criteria';

    /**
     * @access public.
     * @return Mixed.
     */
    public function initialize()
    {
        $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

        if (null === $this->getProperty('active')) {
            $this->setProperty('active', 0);
        }

        return parent::initialize();
    }

    /**
     * @access public.
     * @return Mixed.
     */
    public function beforeSave()
    {
        $criteria = $this->getProperty('criteria');

        if (strpos($criteria, '@') !== 0 && strpos($criteria, '#') !== 0) {
            $this->addFieldError('criteria', $this->modx->lexicon('socialmedia.criteria_err_not_defined', [
                'criteria' => $criteria
            ]));
        }

        $this->object->set('credentials', json_encode($this->getProperty('credentials')));

        return parent::beforeSave();
    }
}

return 'SocialMediaCriteriaCreateProcessor';
