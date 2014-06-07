<?php
require_once dirname(__FILE__) . '/generic.class.php';
/**
 * Gets a list of msForumTotals objects.
 */
class modxStatsWebStatsForumPostProcessor extends modxStatsWebStatsForumGenericProcessor {
    public $valueField = 'posts';
    public $seriesName = 'Posts';
}
return 'modxStatsWebStatsForumPostProcessor';
