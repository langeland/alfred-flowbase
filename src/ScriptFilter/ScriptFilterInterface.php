<?php

namespace FlowBase\ScriptFilter;

use FlowBase\Model\ScriptFilterResult;

interface ScriptFilterInterface
{

    public function initializeObject();

    /**
     * @param $query
     * @return ScriptFilterResult
     */
    public function run($query);

    public function setEnvironment($environment);

}
