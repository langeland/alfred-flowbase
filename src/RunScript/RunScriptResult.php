<?php

namespace FlowBase\RunScript;

use FlowBase\Environment;

class RunScriptResult implements \JsonSerializable
{

    protected $argument = '';
    protected $variables = [];

    public function setArgument(string $argument)
    {
        $this->argument = $argument;
        return $this;
    }

    public function addVariables($variable)
    {
        $this->variables[] = $variable;
        return $this;
    }

    /**
     * @see https://www.alfredapp.com/help/workflows/utilities/json/
     * @return array[]
     */
    public function jsonSerialize()
    {
        $result = [
            'alfredworkflow' => [
                'arg' => $this->argument,
                'config' => [],
                'variables' => $this->variables,
            ],
        ];

        return $result;
    }
}
