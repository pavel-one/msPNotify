<?php

$settings = array();
$query = $modx->newQuery('modSystemSetting');
$query->where(array('namespace:='=>'mspnnotify'));

if($collection = $modx->getCollection('modSystemSetting',$query)) {
    foreach($collection as $item) {
        $setting = $modx->newObject('modSystemSetting');
        $setting->fromArray($item->toArray(),'',true,true);
        $settings[] = $setting;
    }
}

return $settings;