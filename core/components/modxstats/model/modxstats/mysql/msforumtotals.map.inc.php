<?php
/**
 * modxStats
 *
 * Copyright 2014 by Mark Hamstra <mark@modmore.com>
 *
 * This file is part of modxStats.
 *
 * @package modxstats
 * @sub-package model
 */

$xpdo_meta_map['msForumTotals']= array (
  'package' => 'modxstats',
  'version' => '1.1',
  'table' => 'modxstats_forum_totals',
  'fields' => 
  array (
    'collected_on' => 0,
    'recent_posts' => 0,
    'posts' => 0,
    'threads' => 0,
    'members' => 0,
  ),
  'fieldMeta' => 
  array (
    'collected_on' => 
    array (
      'dbtype' => 'int',
      'precision' => '15',
      'phptype' => 'int',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'recent_posts' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
    'posts' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
    'threads' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
    'members' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
  ),
);
