<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 */
// Grab modxStats for the model
$path = $modx->getOption('modxstats.core_path', null, $modx->getOption('core_path') . 'components/modxstats/');
$modxstats = $modx->getService('modxstats', 'modxStats', $path . 'model/modxstats/');

$phs = array();

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
$phs['forum_totals'] = $fs;

return $modxstats->getChunk('wrapper', $phs);