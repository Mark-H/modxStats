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
class msForumTotals extends xPDOSimpleObject {
    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'modxstats'
    );

    public function save($cacheFlag= null) {
        $saved = parent::save($cacheFlag);
        $this->xpdo->getCacheManager()->delete('processors/forum/', $this->cacheOptions);
        $this->xpdo->getCacheManager()->delete('wrapper_phs', $this->cacheOptions);
        return $saved;
    }

    public function remove(array $ancestors= array ()) {
        $removed = parent::remove($ancestors);
        $this->xpdo->getCacheManager()->delete('processors/forum/', $this->cacheOptions);
        $this->xpdo->getCacheManager()->delete('wrapper_phs', $this->cacheOptions);
        return $removed;
    }
}
