<?php
/**
 * modxStats
 *
 * Copyright 2013 by Mark Hamstra <mark@modmore.com>
 * 
 * @package modxstats
 * @var modX $modx
 */

$webActions = array(
    'web/stats/forum/recent',
    'web/stats/forum/posts',
    'web/stats/forum/threads',
    'web/stats/forum/members',
);
if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $webActions)) {
    define('MODX_REQP',false);
}

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';


$corePath = $modx->getOption('modxstats.core_path',null,$modx->getOption('core_path').'components/modxstats/');
require_once $corePath.'model/modxstats/modxstats.class.php';
$modx->modxstats = new modxStats($modx);

$modx->lexicon->load('modxstats:default');

if (in_array($_REQUEST['action'], $webActions)) {
    $version = $modx->getVersionData();
    if (version_compare($version['full_version'],'2.1.1-pl') >= 0) {
        if ($modx->user->hasSessionContext($modx->context->get('key'))) {
            $_SERVER['HTTP_MODAUTH'] = $_SESSION["modx.{$modx->context->get('key')}.user.token"];
        } else {
            $_SERVER['HTTP_MODAUTH'] = 0;
        }
    } else {
        $_SERVER['HTTP_MODAUTH'] = $modx->site_id;
    }
    $_REQUEST['HTTP_MODAUTH'] = $_SERVER['HTTP_MODAUTH'];
}

/* handle request */
$path = $modx->getOption('processorsPath',$modx->modxstats->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
