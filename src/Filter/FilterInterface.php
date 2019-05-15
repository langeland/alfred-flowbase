<?php

namespace FlowBase\Filter;

interface FilterInterface
{

    public function initializeObject();
    public function run($query);
    public function setEnvironment($environment);

}
