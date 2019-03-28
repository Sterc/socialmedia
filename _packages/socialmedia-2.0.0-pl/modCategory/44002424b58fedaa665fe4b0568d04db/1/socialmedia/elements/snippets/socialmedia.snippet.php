<?php
/**
 * Social Media
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <oenetjeerd@sterc.nl>
 */

$instance = $modx->getService('socialmediasnippet', 'SocialMediaSnippet', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path') . 'components/socialmedia/') . 'model/socialmedia/snippets/');

if ($instance instanceof SocialMediaSnippet) {
    return $instance->run($scriptProperties);
}

return '';