<?php
/**
 * modxStats
 *
 * Copyright 2014 by Mark Hamstra <mark@modmore.com>
 *
 * This file is part of modxStat.
 *
*/
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

/* define package name */
define('PKG_NAME','modxStats');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));

require_once dirname(dirname(__FILE__)) . '/config.core.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/modxstats/',
    'model' => $root.'core/components/modxstats/model/',
    'assets' => $root.'assets/components/modxstats/',
    'schema' => $root.'core/components/modxstats/model/schema/',
);
$manager= $modx->getManager();
$generator= $manager->getGenerator();
$generator->classTemplate= <<<EOD
<?php
/**
 * modxStats
 *
 * Copyright 2014 by Mark Hamstra <mark@modmore.com>
 *
 * This file is part of modxStats.
 *
 * @package modxstats
 * @sub-package model
 */
class [+class+] extends [+extends+] {}

EOD;
    $generator->platformTemplate= <<<EOD
<?php
/**
 * modxStats
 *
 * Copyright 2014 by Mark Hamstra <mark@modmore.com>
 *
 * This file is part of modxStats.
 *
 * @package modxstats
 * @sub-package model
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\\\', '/') . '/[+class-lowercase+].class.php');
class [+class+]_[+platform+] extends [+class+] {}

EOD;
    $generator->mapHeader= <<<EOD
<?php
/**
 * modxStats
 *
 * Copyright 2014 by Mark Hamstra <mark@modmore.com>
 *
 * This file is part of modxStats.
 *
 * @package modxstats
 * @sub-package model
 */

EOD;

$generator->parseSchema($sources['schema'].'modxstats.mysql.schema.xml', $sources['model']);


/* Create and/or dump data */
$modx->addPackage(PKG_NAME_LOWER, $sources['model']);

$objects = array(
);

foreach ($objects as $object) {
    if(isset($_REQUEST['dump']) && !empty($_REQUEST['dump'])) {
        $manager->removeObjectContainer($object);
    }
    $manager->createObjectContainer($object);
}


$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();
