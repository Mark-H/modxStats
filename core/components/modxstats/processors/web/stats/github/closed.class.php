<?php
/**
 * Gets a list of msGithubIssues objects.
 */
class modxStatsWebStatsGithubClosedProcessor extends modObjectGetListProcessor {
    public $classKey = 'msGithubIssues';
    public $defaultSortField = 'collected_on';
    public $defaultSortDirection = 'ASC';

    public $series = array('closed' => 'Closed Issues', 'closed_pulls' => 'Closed Pull Requests');
    protected $seriesData = array();

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        return $c;
    }

    /**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        $key = 'processors/github/' . implode('_', array_keys($this->series));
        $cached = $this->modx->getCacheManager()->get($key, array(
            xPDO::OPT_CACHE_KEY => 'modxstats'
        ));
        if (!empty($cached)) return $cached;

        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
        $data = $this->getData();

        foreach ($data['results'] as $object) {
            /** @var msGithubIssues $object */
            foreach ($this->series as $fld => $series) {
                if (!isset($this->seriesData[$fld])) $this->seriesData[$fld] = array();
                $this->seriesData[$fld][] = array(
                    'x' => $object->get('collected_on'),
                    'y' => $object->get($fld)
                );
            }
        }

        $output = array();
        foreach ($this->series as $fld => $name) {
            $output[] = array(
                'name' => $name,
                'data' => $this->seriesData[$fld]
            );
        }

        $output = $this->modx->toJSON($output);

        $this->modx->cacheManager->set($key, $output, 0, array(
            xPDO::OPT_CACHE_KEY => 'modxstats'
        ));
        return $output;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $a = array(
            'x' => $object->get('collected_on'),
            'y' => $object->get($this->valueField)
        );
        return $a;
    }

    /**
     * Generates the output for the Rickshaw graph lib
     *
     * @param array $array
     * @param bool $count
     * @return string
     */
    public function outputArray(array $array, $count = false) {
        return '[{"name":"' . $this->seriesName . '","data":' . $this->modx->toJSON($array) . '}]';
    }
}
return 'modxStatsWebStatsGithubClosedProcessor';
