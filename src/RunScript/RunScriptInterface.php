<?php

namespace FlowBase\RunScript;

interface RunScriptInterface
{
    public function initializeObject();
    public function run($query);
    public function setEnvironment($environment);
}
