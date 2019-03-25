<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->getService('socialmedia', 'SocialMedia', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

if ($modx->socialmedia instanceof SocialMedia) {
    $modx->request->handleRequest([
        'processors_path'   => $modx->socialmedia->config['processors_path'],
        'location'          => ''
    ]);
}
