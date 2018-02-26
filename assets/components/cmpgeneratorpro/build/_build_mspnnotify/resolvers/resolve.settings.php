<?php
/**
 * Resolve system settings
 * @var array $options
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            break;
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx =& $object->xpdo;

            /*if(!$modx->getObject('modSystemSetting', array('key' => 'my_key_setting'))) {
                $setting = $modx->newObject('modSystemSetting');
                $setting->fromArray(array(
                    'key' => 'my_key_setting',
                    'namespace' => 'mspnnotify',
                    'xtype' => 'textfield',
                    'value' => '',
                    'area' => 'general',
                ),'',true,true);
                $setting->save();
            }*/

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;

    }
}
return true;