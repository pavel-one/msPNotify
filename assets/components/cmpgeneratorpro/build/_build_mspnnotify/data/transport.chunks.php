<?php

$chunks = array();
$dir = $sources['chunks'];
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $path = $dir.$file;
            if(!is_dir($path)) {
                $chunk = $modx->newObject('modChunk');
                $chunk->fromArray(array(
                    'name' => getFileName($file, '.chunk'),
                    'description' => '',
                    'snippet' => file_get_contents($path),
                ), '', true, true);
                $chunks[] = $chunk;
            }
        }
        closedir($dh);
    }
}
return $chunks;


