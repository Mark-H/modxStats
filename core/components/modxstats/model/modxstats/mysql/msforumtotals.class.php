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
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/msforumtotals.class.php');
class msForumTotals_mysql extends msForumTotals {}
