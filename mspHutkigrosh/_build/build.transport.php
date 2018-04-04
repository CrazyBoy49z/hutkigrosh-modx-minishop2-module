<?php
/**
 * mspRobokassa build script
 *
 * @package msprobokassa
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(' ', $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

require_once 'build.config.php';

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources = array(
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'resolvers' => $root . '_build/resolvers/',
    'chunks' => $root . 'core/components/' . PKG_EXTENDED_LOWER . '/elements/chunks/',
    'snippets' => $root . 'core/components/' . PKG_EXTENDED_LOWER . '/elements/snippets/',
    'source_assets' => $root . 'assets/components/' . PKG_EXTENDED_LOWER,
    'source_core' => $root . 'core/components/' . PKG_EXTENDED_LOWER,
    'docs' => $root . 'docs/'
);
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once $sources['build'] . '/includes/functions.php';

$modx = new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
//$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');
$modx->log(modX::LOG_LEVEL_INFO, 'Created Transport Package.');

/* Add settings */
$settings = include $sources['data'] . 'transport.settings.php';
if (!is_array($settings)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in settings.');
} else {
    $attributes = array(
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => BUILD_SETTING_UPDATE,
    );
    foreach ($settings as $setting) {
        $vehicle = $builder->createVehicle($setting, $attributes);
        $builder->putVehicle($vehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' System Settings.');
}
unset($settings, $setting, $attributes);


/* @var msPayment $payment */
$payment = $modx->newObject('msPayment');
$payment->fromArray(array(
    'name' => 'Hutkigrosh',
    'active' => 0,
    'class' => 'Hutkigrosh'
));

/* create payment vehicle */
$attributes = array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => false,
);
$vehicle = $builder->createVehicle($payment, $attributes);
$builder->putVehicle($vehicle);

// Load minishop2 category
$modx->log(xPDO::LOG_LEVEL_INFO, 'Loading ' . PKG_EXTENDED . ' category.');
/** @var modCategory $category */
$category = $modx->getObject('modCategory', array('category' => PKG_EXTENDED));
if (empty($category)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load category with name ' . PKG_EXTENDED);
}
// Add snippets
$snippets = include $sources['data'] . 'transport.snippets.php';
if (!is_array($snippets)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in snippets.');
} else {
    $category->addMany($snippets);
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($snippets) . ' snippets.');
}
// Add chunks
$chunks = include $sources['data'] . 'transport.chunks.php';
if (!is_array($chunks)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in chunks.');
} else {
    $category->addMany($chunks);
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($chunks) . ' chunks.');
}

$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => false,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Chunks' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => BUILD_CHUNK_UPDATE,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    ),
);
$vehicle = $builder->createVehicle($category, $attr);

/**
 * Тут важен именно перебор всех файлов, иначе при удалении пакета будет удалена целиком директория minishop2,
 * а не только файлы hutkigorhs
 */
$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers to payment...');
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sources['source_assets']), RecursiveIteratorIterator::SELF_FIRST);
foreach ($files as $pathname => $file) {
    if (is_dir($pathname))
        continue;
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding asserts file ' . $pathname);
    $dir = str_replace($root . "assets", "", dirname($pathname) . '/');
    $vehicle->resolve('file', array(
        'source' => $pathname,
        'target' => "return MODX_ASSETS_PATH . '{$dir}';",
    ));
}
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sources['source_core']), RecursiveIteratorIterator::SELF_FIRST);
foreach ($files as $pathname => $file) {
    if (is_dir($pathname))
        continue;
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding core file ' . $pathname);
    $dir = str_replace($root . "core", "", dirname($pathname) . '/');
    $vehicle->resolve('file', array(
        'source' => $pathname,
        'target' => "return MODX_CORE_PATH . '{$dir}';",
    ));
}
//$vehicle->resolve('file',array(
//    'source' => $sources['source_assets'],
//    'target' => "return MODX_ASSETS_PATH . 'components/';",
//));
//$vehicle->resolve('file',array(
//    'source' => $sources['source_core'],
//    'target' => "return MODX_CORE_PATH . 'components/';",
//));
//unset($file, $attributes);

$resolvers = array('settings');
foreach ($resolvers as $resolver) {
    if ($vehicle->resolve('php', array('source' => $sources['resolvers'] . 'resolve.' . $resolver . '.php'))) {
        $modx->log(modX::LOG_LEVEL_INFO, 'Added resolver "' . $resolver . '" to category.');
    } else {
        $modx->log(modX::LOG_LEVEL_INFO, 'Could not add resolver "' . $resolver . '" to category.');
    }
}

flush();
$builder->putVehicle($vehicle);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt')
    /*
    ,'setup-options' => array(
            'source' => $sources['build'].'setup.options.php',
    ),
    */
));
$modx->log(modX::LOG_LEVEL_INFO, 'Added package attributes and setup options.');

/* zip up package */
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();
$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Package Built.<br />");

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Execution time: {$totalTime}\n");
echo '</pre>';