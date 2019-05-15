<?php

namespace FlowBase\Filter;

use FlowBase\Environment;

abstract class AbstractFilter
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
