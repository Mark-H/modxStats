<?php
require_once dirname(__FILE__) . '/generic.class.php';
/**
 * Gets a list of msForumTotals objects.
 */
class modxStatsWebStatsForumMemberProcessor extends modxStatsWebStatsForumGenericProcessor {
    public $valueField = 'members';
    public $seriesName = 'Total # of Members';
}
return 'modxStatsWebStatsForumMemberProcessor';
