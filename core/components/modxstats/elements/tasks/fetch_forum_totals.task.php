<?php
/**
 * @var modX $modx
 * @var sTask $task
 * @var sTaskRun $run
 * @var array $scriptProperties
 */

// Repeat in a hour
$task->schedule('+59 minutes');

// Grab modxStats for the model
$path = $modx->getOption('modxstats.core_path', null, $modx->getOption('core_path') . 'components/modxstats/');
$modxstats = $modx->getService('modxstats', 'modxStats', $path . 'model/modxstats/');

// Load the recent posts page from the forum; this contains all the info we need
$html = file_get_contents('http://forums.modx.com/thread/recent');

// We'll extract these in a moment using some regex.
$recentPosts = 0;
$posts = 0;
$threads = 0;
$members = 0;

// Extract the recent posts
$found = preg_match('/<h1>Recent Posts \(([\d,]+)?\)<\/h1>/', $html, $matches);
if ($found && isset($matches[1])) {
    $recentPosts = (int)str_replace(',', '', $matches[1]);
}

// Extract number of posts
$found = preg_match('/<li>Posts: <span>([\d,]+)<\/span><\/li>/', $html, $matches);
if ($found && isset($matches[1])) {
    $posts = (int)str_replace(',', '', $matches[1]);
}

// Extract number of threads
$found = preg_match('/<li>Threads: <span>([\d,]+)<\/span><\/li>/', $html, $matches);
if ($found && isset($matches[1])) {
    $threads = (int)str_replace(',', '', $matches[1]);
}

// Extract number of members
$found = preg_match('/<li>Members: <span>([\d,]+)<\/span><\/li>/', $html, $matches);
if ($found && isset($matches[1])) {
    $members = (int)str_replace(',', '', $matches[1]);
}

// Collect stuff
$data = array(
    'collected_on' => time(),
    'recent_posts' => $recentPosts,
    'posts' => $posts,
    'threads' => $threads,
    'members' => $members,
);

// Store it in the database
$forumTotals = $modx->newObject('msForumTotals', $data);
$forumTotals->fromArray($data);

if (!$forumTotals->save()) {
    $run->addError('error_save_object');
}

// Return the data to Scheduler
return 'Collected data! ' . $modx->toJSON($data);
