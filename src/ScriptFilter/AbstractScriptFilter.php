<?php

namespace FlowBase\ScriptFilter;

use FlowBase\Environment;
use FlowBase\Filter\ScriptFilterInterface;
use FlowBase\Model\ScriptFilterResult;

abstract class AbstractScriptFilter
{

    /**
     * @var Environment
     */
    protected $environment;

    public function initializeObject()
    {
    }

    public function setEnvironment($environment){
        $this->environment = $environment;
    }

}
