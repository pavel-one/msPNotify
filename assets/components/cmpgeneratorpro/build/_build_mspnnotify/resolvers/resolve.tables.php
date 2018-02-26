<?php
$pkgName = 'msPNnotify';
$pkgNameLower = mb_strtolower($pkgName);
if ($object->xpdo) {
    $modx =& $object->xpdo;
    $modelPath = $modx->getOption("{$pkgNameLower}.core_path",null,$modx->getOption('core_path')."components/{$pkgNameLower}/").'model/';
    $modx->addPackage($pkgNameLower,$modelPath);
    $manager = $modx->getManager();
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
        case xPDOTransport::ACTION_UNINSTALL:/**/
            break;
    }
}
return true;