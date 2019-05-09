<?php


namespace FlowBase;


class Workflow
{

    private $arguments;

    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }

    public function run()
    {
        try {
            $filter = $this->resolveFilter();
            $result = $filter->run(
                $this->resolveQuery()
            );
            $output = json_encode($result);
            print($output);
            exit(0);
        } catch (\Exception $exception) {
            \FlowBase\Utility\Debugger::log($exception->getMessage());
            exit(1);
        }
    }


    private function resolveQuery()
    {
        if (key_exists('query', $this->arguments)) {
            $query = $this->arguments['query'];
        } else {
            $query = $_SERVER['argv'][2];
        }

        return $query;
    }

    private function resolveFilter()
    {
        if (key_exists('filter', $this->arguments)) {
            $filterName = $this->arguments['filter'];
        } else {
            $filterName = $_SERVER['argv'][1];
        }

        if (!class_exists($filterName)) {
            throw new \Exception('Cannot load workflow handler ' . $filterName, 1557407192);
        }

        $filter = new $filterName();
        return $filter;
    }


}