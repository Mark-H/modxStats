<?php
/**
 * Gets a list of msForumTotals objects.
 */
class modxStatsWebStatsForumGenericProcessor extends modObjectGetListProcessor {
    public $classKey = 'msForumTotals';
    public $defaultSortField = 'collected_on';
    public $defaultSortDirection = 'ASC';

    public $valueField = '';
    public $seriesName = '';

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        return $c;
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
