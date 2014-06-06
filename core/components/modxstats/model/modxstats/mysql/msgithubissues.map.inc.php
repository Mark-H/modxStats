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

$xpdo_meta_map['msGithubIssues']= array (
  'package' => 'modxstats',
  'version' => '1.1',
  'table' => 'modxstats_github_issues',
  'fields' => 
  array (
    'collected_on' => 0,
    'open' => 0,
    'open_pulls' => 0,
    'closed' => '0',
    'closed_pulls' => '0',
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
    'open' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
    'open_pulls' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'default' => 0,
      'null' => false,
    ),
    'closed' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'int',
      'default' => '0',
      'null' => false,
    ),
    'closed_pulls' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'int',
      'default' => '0',
      'null' => false,
    ),
  ),
);
