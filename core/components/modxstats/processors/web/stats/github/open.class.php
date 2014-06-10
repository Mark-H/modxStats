<?php
require_once dirname(__FILE__) . '/closed.class.php';
/**
 * Gets a list of msGithubIssues objects.
 */
class modxStatsWebStatsGithubOpenProcessor extends modxStatsWebStatsGithubClosedProcessor {
    public $series = array('open' => 'Open Issues', 'open_pulls' => 'Open Pull Requests');
}
return 'modxStatsWebStatsGithubOpenProcessor';
