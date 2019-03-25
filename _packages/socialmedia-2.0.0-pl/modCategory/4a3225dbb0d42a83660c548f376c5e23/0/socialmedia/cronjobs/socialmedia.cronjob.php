<?php

/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('web');

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

/*
 * Put the options in the $options variable.
 * We use getopt for CLI executions and $_GET for http executions.
 */
$options = [];

if (XPDO_CLI_MODE) {
    $options = getopt('', ['debug', 'hash::']);
} else {
    $options = $_GET;
}

if (!isset($options['hash']) || $options['hash'] !== $modx->getOption('socialmedia.cronjob_hash')) {
    $modx->log(modX::LOG_LEVEL_INFO, 'ERROR:: Cannot initialize service, no valid hash provided.');

    exit();
}

$service = $modx->getService('socialMediaCronjob', 'SocialMediaCronjob', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/');

if ($service instanceof SocialMedia) {
    if (isset($options['debug'])) {
        $service->setDebugMode(true);
    }

    $service->run();
} else {
    $modx->log(modX::LOG_LEVEL_INFO, 'ERROR:: Cannot initialize service.');
}
