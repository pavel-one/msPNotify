<?php

$plugins = array();
$dir = $sources['plugins'];
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $path = $dir.$file;
            if(!is_dir($path)) {
                $name = getFileName($file, '.plugin');
                $plugin = $modx->newObject('modPlugin');
                $plugin->fromArray(array(
                 'name' => $name,
                 'description' => '',
                 'plugincode' => getSnippetContent($path),
                ),'',true,true);

                if($insPlugin = $modx->getObject('modPlugin',array('name:='=>$name))) {
                    if($insPlugin->PluginEvents) {
                        $events = array();
                        foreach($insPlugin->PluginEvents as $e) {
                            $event = $modx->newObject('modPluginEvent');
                            $event->fromArray(array(
                                'event' => $e->get('event'),
                                'priority' => $e->get('priority'),
                                'propertyset' => $e->get('propertyset'),
                            ),'',true,true);
                            $events[] = $event;
                        }
                        if (!empty($events)) {
                            $plugin->addMany($events);
                        }
                    }
                }

                $plugins[] = $plugin;
            }
        }
        closedir($dh);
    }
}
return $plugins;


