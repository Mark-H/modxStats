<?php
/* Get the core config */
if (!file_exists(dirname(dirname(__FILE__)).'/config.core.php')) {
    die('ERROR: missing '.dirname(dirname(__FILE__)).'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(dirname(__FILE__)).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');

$componentPath = dirname(dirname(__FILE__));

/** @var modxStats $modxstats */
$modxstats = $modx->getService('modxstats','modxStats', $componentPath.'/core/components/modxstats/model/modxstats/', array(
    'modxstats.core_path' => $componentPath.'/core/components/modxstats/',
));


/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'modxstats',
    'path' => $componentPath.'/core/components/modxstats/',
    'assets_path' => $componentPath.'/assets/components/modxstats/',
),'name', false)) {
    echo "Error creating namespace modxstats.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'modxstats.core_path',
    'value' => $componentPath.'/core/components/modxstats/',
    'xtype' => 'textfield',
    'namespace' => 'modxstats',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating modxstats.core_path setting.\n";
}

if (!createObject('modSystemSetting', array(
    'key' => 'modxstats.assets_path',
    'value' => $componentPath.'/assets/components/modxstats/',
    'xtype' => 'textfield',
    'namespace' => 'modxstats',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating modxstats.assets_path setting.\n";
}

/* Fetch assets url */
$url = 'http';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
    $url .= 's';
}
$url .= '://'.$_SERVER["SERVER_NAME"];
if ($_SERVER['SERVER_PORT'] != '80') {
    $url .= ':'.$_SERVER['SERVER_PORT'];
}
$requestUri = $_SERVER['REQUEST_URI'];
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/').'/';
$assetsUrl = "{$url}{$requestUri}assets/components/modxstats/";

if (!createObject('modSystemSetting', array(
    'key' => 'modxstats.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'modxstats',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating modxstats.assets_url setting.\n";
}

/** @var Scheduler $scheduler */
$path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
$scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');

if ($scheduler) {
    if (!createObject('sFileTask', array(
        'class_key' => 'sFileTask',
        'content' => 'elements/tasks/fetch_forum_totals.task.php',
        'namespace' => 'modxstats',
        'reference' => 'fetch_forum_totals',
        'description' => 'Fetches a number of statistics from the MODX forums.'
    ), 'reference', true)) {
        echo "Error creating sTask object";
    }
    if (!createObject('sFileTask', array(
        'class_key' => 'sFileTask',
        'content' => 'elements/tasks/fetch_github_stats.task.php',
        'namespace' => 'modxstats',
        'reference' => 'fetch_github_stats',
        'description' => 'Fetches the number of open/closed issues and pull requests.'
    ), 'reference', true)) {
        echo "Error creating sTask object";
    }
}

if (!createObject('modCategory', array(
    'category' => 'modxStats',
    'parent' => 0,
), 'category', false)) {
    echo "Error creating Category.\n";
}

$categoryId = 0;
$category = $modx->getObject('modCategory', array('category' => 'modxStats'));
if ($category) {
    $categoryId = $category->get('id');
}

/**
 * Snippets
 * @var modSnippet $snippet
 */
if (!createObject('modSnippet', array(
    'name' => 'modxStats',
    'static' => true,
    'static_file' => '[[++modxstats.core_path]]elements/snippets/modxstats.snippet.php',
    'category' => $categoryId,
), 'name', false)) {
    echo "Error creating snippet.\n";
}

/**
 * Plugins
 */
/*if (!createObject('modPlugin', array(
    'name' => 'modxStats',
    'static' => true,
    'static_file' => '[[++modxstats.core_path]]elements/plugins/modxstats.plugin.php',
    'category' => $categoryId
), 'name', true)) {
    echo "Error creating modPlugin.\n";
}*/
/** @var modPlugin $modxStatsPlugin */
/*$modxStatsPlugin = $modx->getObject('modPlugin', array('name' => 'modxStats'));
if ($modxStatsPlugin) {
    if (!createObject('modPluginEvent', array(
        'pluginid' => $modxStatsPlugin->get('id'),
        'event' => 'OnPageNotFound',
        'priority' => 0,
    ), array('pluginid','event'), false)) {
        echo "Error creating modPluginEvent.\n";
    }
}*/


/** 
 * Menu / Action 
 */
/*if (!createObject('modAction', array(
    'namespace' => 'modxstats',
    'parent' => '0',
    'controller' => 'controllers/index',
    'haslayout' => '1',
    'lang_topics' => 'modxstats:default',
), 'namespace', true)) {
    echo "Error creating action.\n";
}
$action = $modx->getObject('modAction', array(
    'namespace' => 'modxstats'
));

if ($action) {
    if (!createObject('modMenu', array(
        'text' => 'modxstats',
        'parent' => 'components',
        'description' => 'modxstats.menu_desc',
        'icon' => 'images/icons/plugin.gif',
        'menuindex' => '0',
        'action' => $action->get('id')
    ), 'text', false)) {
        echo "Error creating menu.\n";
    }
}*/

$manager = $modx->getManager();

// Increase severity level for logging.
$logLevel = $modx->setLogLevel(modX::LOG_LEVEL_FATAL);

/* Create the tables */
$objectContainers = array(
    'msForumTotals',
    'msGithubIssues'
);
echo "Creating tables...\n";

foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}


// Restore log level
$modx->setLogLevel($logLevel);

echo 'Done';

/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        if (is_array($primaryField)) {
            $condition = array();
            foreach ($primaryField as $key) {
                $condition[$key] = $data[$key];
            }
        }
        else {
            $condition = array($primaryField => $data[$primaryField]);
        }
        $object = $modx->getObject($className, $condition);
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                $condition = $modx->toJSON($condition);
                echo "Skipping {$className} {$condition}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}
