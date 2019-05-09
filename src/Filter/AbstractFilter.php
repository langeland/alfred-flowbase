<?php

namespace FlowBase\Filter;

abstract class AbstractFilter
{

    protected $environment;

    public function setEnvironment($environment){
        $this->environment = $environment;
    }

}
