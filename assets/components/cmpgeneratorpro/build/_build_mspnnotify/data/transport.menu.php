<?php

$menus  =  array();
$query = $modx->newQuery('modMenu');
$query->where(array('namespace:='=>'mspnnotify'));

if($collection = $modx->getCollection('modMenu',$query)) {
    foreach ($collection as $item) {
        $menu= $modx->newObject('modMenu');
        $menu->fromArray($item->toArray(),'',true,true);
        $menus[] = $menu;
    }
}

return $menus;