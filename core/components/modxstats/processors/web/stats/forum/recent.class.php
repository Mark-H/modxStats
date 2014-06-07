<?php
require_once dirname(__FILE__) . '/generic.class.php';
/**
 * Gets a list of msForumTotals objects.
 */
class modxStatsWebStatsForumRecentProcessor extends modxStatsWebStatsForumGenericProcessor {
    public $valueField = 'recent_posts';
    public $seriesName = 'Recent Posts';
}
return 'modxStatsWebStatsForumRecentProcessor';
