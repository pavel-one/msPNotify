<?php


require_once '/home/modstore/web/devmod.cms.pavel.one/public_html/core/config/config.inc.php';

$pkg_name = 'msPNnotify';

/* define package */
define('PKG_NAME', $pkg_name);
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
define('PKG_BUILD_DIR','_build_'.strtolower(PKG_NAME));
define('NAMESPACE_NAME', PKG_NAME_LOWER);

define('PKG_PATH', PKG_NAME_LOWER);
define('PKG_CATEGORY', PKG_NAME);

/* define sources */
$root =  dirname(dirname(__FILE__)).'/';


/*
 * Константы
 */


global $sources;
$sources = array(
    'root' => $root,
    'build' => $root.PKG_BUILD_DIR.'/',
    'data' => $root.PKG_BUILD_DIR.'/data/',
    'packages' => $root.PKG_BUILD_DIR.'/packages/',
    'resolvers' => $root.PKG_BUILD_DIR.'/resolvers/',
    'chunks' => MODX_CORE_PATH.'components/'.PKG_PATH.'/elements/chunks/',
    'snippets' => MODX_CORE_PATH.'components/'.PKG_PATH.'/elements/snippets/',
    'plugins' => MODX_CORE_PATH.'components/'.PKG_PATH.'/elements/plugins/',
    'lexicon' => MODX_CORE_PATH . 'components/'.PKG_PATH.'/lexicon/',
    'docs' => MODX_CORE_PATH.'components/'.PKG_PATH.'/docs/',
    'pages' => MODX_CORE_PATH.'components/'.PKG_PATH.'/elements/pages/',
    'source_assets' => MODX_ASSETS_PATH.'components/'.PKG_PATH,
    'source_core' => MODX_CORE_PATH.'components/'.PKG_PATH,
    'source_manager' => MODX_BASE_PATH.'manager/components/'.PKG_PATH,
    'templates' => MODX_CORE_PATH.'components/'.PKG_PATH.'/elements/templates/',
    'model' => MODX_CORE_PATH.'components/'.PKG_PATH.'/model/',
);
unset($root);


require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once $sources['build'] . 'includes/functions.php';

$modx= new modX();
$modx->initialize('mgr'); 