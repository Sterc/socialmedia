<?php

/**
 * Social Media
 *
 * Copyright 2019 by Sterc <modx@sterc.nl>
 */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modx->addPackage('socialmedia', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path') . 'components/socialmedia/') . 'model/');

            $manager = $modx->getManager();

            $manager->createObjectContainer('SocialMediaMessage');
            $manager->createObjectContainer('SocialMediaCriteria');

            break;
    }
}

return true;