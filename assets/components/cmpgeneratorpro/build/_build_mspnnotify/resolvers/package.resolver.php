<?php
/**
 * @var array $options
 */

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx->addExtensionPackage('mspnnotify', '[[++core_path]]components/mspnnotify/model/');
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $modx->removeExtensionPackage('mspnnotify');
            break;
    }
}
return true;