<?php

namespace FlowBase\Filter;

interface FilterInterface
{

    public function run($query);
    public function setEnvironment($environment);

}
