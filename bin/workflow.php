<?php

use FlowBase\Workflow as WorkflowAlias;

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    echo 'Missing ' . __DIR__ . '/../vendor/autoload.php, update by the composer.' . PHP_EOL;
    exit(2);
}

if(isset($arguments) === false) {
    $arguments = [];
}

$workflow = new WorkflowAlias($arguments);
$workflow->run();

