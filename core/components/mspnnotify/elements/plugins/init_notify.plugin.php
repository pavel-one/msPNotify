<?php

//OnWebPageInit
//OnMODXInit
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnMODXInit':
        $modx->setOption('ms2_frontend_js', MODX_ASSETS_URL.'components/mspnnotify/js/web/ms2/ms2.js');
        break;
    case 'OnWebPageInit':
        $modx->regClientScript(MODX_ASSETS_URL.'components/mspnnotify/js/web/pn/pnotify.custom.js');
        $modx->regClientScript(MODX_ASSETS_URL.'components/mspnnotify/js/web/pn/default.js');
        $modx->regClientCSS(MODX_ASSETS_URL.'components/mspnnotify/js/web/pn/pnotify.custom.css');
        break;
}