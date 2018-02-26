<?php
error_reporting(E_ALL ^E_NOTICE);
ini_set('display_errors', true);


$pkg_version = '1.0.0';
$pkg_release = 'beta';
define('PKG_VERSION', $pkg_version); 
define('PKG_RELEASE', $pkg_release); 


$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tstart = $mtime;

require_once dirname(__FILE__). '/build.config.php';
$modx->setLogLevel(xPDO::LOG_LEVEL_INFO);

if(hasPostBuild()) {
    $log_file_name = 'build_' . PKG_NAME_LOWER . '.log';
    $filepath = __DIR__ . '/';
    $log_file = $filepath.$log_file_name;
    if(file_exists($log_file)){
        unlink($log_file);
    }
    $modx->setLogTarget(array(
        'target' => 'FILE',
        'options' => array(
            'filename' => $log_file_name,
            'filepath' => $filepath
        )
    ));
} else {
    $modx->setLogTarget('ECHO'); echo '<pre>'; flush();
    print '<pre>';
}


$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');
$modx->getService('lexicon','modLexicon');
$modx->lexicon->load(PKG_NAME_LOWER.':properties');

/* load action/menu */
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Action' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
        ),
    ),
);



/* add namespace */
$namespace = $modx->newObject('modNamespace');
$namespace->set('name', NAMESPACE_NAME);
$namespace->set('path',"{core_path}components/".PKG_NAME_LOWER."/");
$namespace->set('assets_path',"{assets_path}components/".PKG_NAME_LOWER."/");
$vehicle = $builder->createVehicle($namespace,array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
));
$builder->putVehicle($vehicle);
$modx->log(xPDO::LOG_LEVEL_INFO,"Packaged in ".NAMESPACE_NAME." namespace."); flush();
unset($vehicle,$namespace);
 
/* create category */
$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in category.'); flush();


$snippets = include $sources['data'].'transport.snippets.php';
if($snippets) {
    $category->addMany($snippets);
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaging in  ' . count($snippets) . ' snippets.');
}

$chunks = include $sources['data'].'transport.chunks.php';
if($chunks) {
    $category->addMany($chunks);
    $modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($chunks).' chunks.');
}


$plugins = include $sources['data'].'transport.plugins.php';
if($plugins) {
    $category->addMany($plugins);
    $modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($plugins).' plugins.');
}

/* load system settings */
$settings = include $sources['data'].'transport.settings.php';
if (!is_array($settings)) {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not package in settings.');
} else {
    $attributes= array(
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => BUILD_SETTING_UPDATE,
    );
    foreach ($settings as $setting) {
        $vehicle = $builder->createVehicle($setting,$attributes);
        $builder->putVehicle($vehicle);
    }
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($settings).' System Settings.');
}
unset($settings,$setting,$attributes);

  
/* menus */
$menus = include $sources['data'].'transport.menu.php';
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => BUILD_MENU_UPDATE,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Action' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => BUILD_ACTION_UPDATE,
            xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
        ),
    ),
);
foreach($menus as $menu){
    $vehicle= $builder->createVehicle($menu, $attributes);
    $builder->putVehicle($vehicle);
    $modx->log(xPDO::LOG_LEVEL_INFO,"Packaged in ".$menu->text." menu.");
}
unset($vehicle,$action);

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Chunks'=> array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Plugins' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'PluginEvents' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
        ),
    )
);


$vehicle = $builder->createVehicle($category,$attr);
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in CorePath'); flush();

$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in AssetsPath'); flush();


$modx->log(xPDO::LOG_LEVEL_INFO,'Adding in PHP resolvers...');
$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'resolve.tables.php',
));

$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'resolve.settings.php',
));

$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'package.resolver.php',
));

$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in resolvers.'); flush();

$builder->putVehicle($vehicle);



/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'), 
));
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in package attributes.'); flush();

$modx->log(xPDO::LOG_LEVEL_INFO,'Packing...'); flush();
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(xPDO::LOG_LEVEL_INFO,"\nPackage Built.\nExecution time: {$totalTime}\n");

$file = $builder->directory . $builder->filename;
if(file_exists($file)) {
    if (!copy($file, $sources['packages'].$builder->filename)) {
        $modx->log(xPDO::LOG_LEVEL_INFO,"\nError copy file $file...\n");
    }
}

session_write_close();

if(hasPostBuild() && file_exists($log_file)) {
    if ($log = file($log_file)) {
        $out = '';
        foreach ($log as $val) {
            $out .= $val ? '<br>' . $val : $val;
        }
        echo $out;
    }
}
exit ();
?>
