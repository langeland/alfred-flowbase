<?php

use FlowBase\Workflow as WorkflowAlias;

$autoloader = __DIR__ . '/../../../autoload.php';

if (file_exists($autoloader)) {
    require $autoloader;
} else {
    echo 'Missing ' . $autoloader . ', update by the composer.' . PHP_EOL;
    exit(2);
}

if(isset($arguments) === false) {
    $arguments = [];
}

$workflow = new WorkflowAlias($arguments);
$workflow->run();

