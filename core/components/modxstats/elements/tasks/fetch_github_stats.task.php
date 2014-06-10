<?php
/**
 * @var modX $modx
 * @var sTask $task
 * @var sTaskRun $run
 * @var array $scriptProperties
 */

// Repeat in an hour
$task->schedule(time()); //@fixme
$task->schedule('+59 minutes');

// Grab modxStats for the model
$path = $modx->getOption('modxstats.core_path', null, $modx->getOption('core_path') . 'components/modxstats/');
$modxstats = $modx->getService('modxstats', 'modxStats', $path . 'model/modxstats/');

// Grab a modRestClient
$modx->getService('rest','rest.modRestClient', '', array(
    'contentType' => 'json'
));
$loaded = $modx->rest->getConnection();
if (!$loaded) {
    $run->addError('rest_not_loaded', array(
        'message' => 'Could not load a valid modRestClient instance for retrieving data from GitHub.'
    ));
    return '';
}
$modx->rest->setResponseType('json');

/** @var msGithubIssues $stats */
$stats = $modx->newObject('msGithubIssues');
$stats->set('collected_on', time());

// Grab the open issues
$response = $modx->rest->request('https://api.github.com', '/search/issues', 'GET', array(
    'q' => urldecode('repo:modxcms/revolution+type:issue+state:open')
));
$data = $response->fromJSON();
if (isset($data['total_count'])) {
    $stats->set('open', $data['total_count']);
}

// Grab the open pull requests
$response = $modx->rest->request('https://api.github.com', '/search/issues', 'GET', array(
    'q' => urldecode('repo:modxcms/revolution+type:pr+state:open')
));
$data = $response->fromJSON();
if (isset($data['total_count'])) {
    $stats->set('open_pulls', $data['total_count']);
}

// Grab the closed issues
$response = $modx->rest->request('https://api.github.com', '/search/issues', 'GET', array(
    'q' => urldecode('repo:modxcms/revolution+type:issue+state:closed')
));
$data = $response->fromJSON();
if (isset($data['total_count'])) {
    $stats->set('closed', $data['total_count']);
}
// Grab the open pull requests
$response = $modx->rest->request('https://api.github.com', '/search/issues', 'GET', array(
    'q' => urldecode('repo:modxcms/revolution+type:pr+state:closed')
));
$data = $response->fromJSON();
if (isset($data['total_count'])) {
    $stats->set('closed_pulls', $data['total_count']);
}

if (!$stats->save()) {
    $run->addError('error_save_object');
}

// Return the data to Scheduler
return 'Collected data! ' . $stats->toJSON();
