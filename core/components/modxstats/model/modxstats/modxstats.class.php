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
     * Array of cached chunks
     *
     * @var array
     */
    public $chunks = array();
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

    /**
     * Gets a Chunk and caches it; defaults to file based chunks.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @param string $type
     * @return string The processed content of the Chunk
     * @author Shaun "splittingred" McCormick
     */
    public function getChunk($name, $properties = array(), $type = '') {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            if (!empty($type)) {
                $chunk = $this->_getTplChunk($name . '_' . $type);
            }
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name);
            }
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
    * Returns a modChunk object from a template file.
    *
    * @access private
    * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
    * @param string $postFix The postfix to append to the name
    * @return modChunk/boolean Returns the modChunk object if found, otherwise false.
    * @author Shaun "splittingred" McCormick
    */
    private function _getTplChunk($name,$postFix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['elementsPath'].'chunks/'.strtolower($name).$postFix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            /* @var modChunk $chunk */
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}

