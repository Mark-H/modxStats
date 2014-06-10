<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 */
// Grab modxStats for the model
$path = $modx->getOption('modxstats.core_path', null, $modx->getOption('core_path') . 'components/modxstats/');
$modxstats = $modx->getService('modxstats', 'modxStats', $path . 'model/modxstats/');

$phs = $modx->getCacheManager()->get('wrapper_phs', array(
    xPDO::OPT_CACHE_KEY => 'modxstats'
));

if (empty($phs)) {
    $phs = array();
    $phs['assets_url'] = $modxstats->config['assetsUrl'];

    // Grab forum stats
    $fs = array();
    $c = $modx->newQuery('msForumTotals');
    $c->sortby('collected_on', 'DESC');
    $stats = $modx->getCollection('msForumTotals', $c);

    /** @var msForumTotals $forumStat */
    foreach ($stats as $forumStat) {
        $ta = $forumStat->toArray();
        $fs[] = $modxstats->getChunk('forum/row', $ta);
    }
    $fs = implode('', $fs);
    $phs['forum_stats'] = $fs;

    // Grab GitHub stats
    $fs = array();
    $c = $modx->newQuery('msGithubIssues');
    $c->sortby('collected_on', 'DESC');
    $stats = $modx->getCollection('msGithubIssues', $c);

    /** @var msGithubIssues $githubStat */
    foreach ($stats as $githubStat) {
        $ta = $githubStat->toArray();
        $fs[] = $modxstats->getChunk('github/row', $ta);
    }
    $fs = implode('', $fs);
    $phs['github_stats'] = $fs;

    $modx->cacheManager->set('wrapper_phs', $phs, 60 * 5, array(
        xPDO::OPT_CACHE_KEY => 'modxstats'
    ));
}

$output = $modxstats->getChunk('wrapper', $phs);
return $output;
