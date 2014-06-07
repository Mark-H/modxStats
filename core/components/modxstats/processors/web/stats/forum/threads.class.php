<?php
require_once dirname(__FILE__) . '/generic.class.php';
/**
 * Gets a list of msForumTotals objects.
 */
class modxStatsWebStatsForumThreadsProcessor extends modxStatsWebStatsForumGenericProcessor {
    public $valueField = 'threads';
    public $seriesName = 'Threads';
}
return 'modxStatsWebStatsForumThreadsProcessor';
