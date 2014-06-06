<?php
/**
 * modxStats
 *
 * Copyright 2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of modxStats.
 *
 * @package modxstats
 */

class modxStats
{
    /**
     * @var \modX $modx
     */
    public $modx;
    /**
     * Array of configuration options, primarily paths.
     *
     * @var array
     */
    public $config = array();
    /**
     * xPDO Cache Manager configuration
     *
     * @var array
     */
    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'modxstats',
    );

    /**
     * @param \modX $modx
     * @param array $config
     */
    public function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('modxstats.core_path', $config, $this->modx->getOption('core_path') . 'components/modxstats/');
        $assetsUrl = $this->modx->getOption('modxstats.assets_url', $config, $this->modx->getOption('assets_url') . 'components/modxstats/');
        $assetsPath = $this->modx->getOption('modxstats.assets_path', $config, $this->modx->getOption('assets_path') . 'components/modxstats/');
        $managerUrl = $this->modx->getOption('manager_url', $config, $this->modx->getOption('base_url') . 'manager/');

        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath . 'model/',
            'processorsPath' => $basePath . 'processors/',
            'elementsPath' => $basePath . 'elements/',
            'templatesPath' => $basePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'managerUrl' => $managerUrl,
        ), $config);
        $this->modx->addPackage('modxstats', $this->config['modelPath']);
    }
}

