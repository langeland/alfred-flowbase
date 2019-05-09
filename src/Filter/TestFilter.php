<?php

namespace FlowBase\Filter;

use FlowBase\Utility\Debugger;

class TestFilter extends AbstractFilter implements FilterInterface
{

    public function run($query)
    {

        Debugger::log('Query: ' . $query, $_SERVER, false);

        $items = [
            'items' =>
                [

                    [
//                        'uid' => 'desktop',
//                        'type' => 'file',
                        'title' => 'Desktop',
                        'subtitle' => 'query: ' . $query,
                        'arg' => $query,
//                        'autocomplete' => 'Desktop',
//                        'icon' =>
//                            [
//                                'type' => 'fileicon',
//                                'path' => '~/Desktop',
//                            ],
                    ],
                ],
        ];

        return $items;

    }

}
