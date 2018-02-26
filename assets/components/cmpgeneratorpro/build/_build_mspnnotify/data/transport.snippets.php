<?php

$snippets = array();
$dir = $sources['snippets'];
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $path = $dir.$file;
            if(!is_dir($path)) {
                $snippet = $modx->newObject('modSnippet');
                $snippet->fromArray(array(
                    'name' => getFileName($file, '.snippet'),
                    'description' => '',
                    'snippet' => getSnippetContent($path),
                ), '', true, true);
                $snippets[] = $snippet;
            }
        }
        closedir($dh);
    }
}
return $snippets;


