<?php

namespace FlowBase\RunScript;

use FlowBase\Environment;

abstract class AbstractRunScript
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
