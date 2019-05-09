<?php


namespace FlowBase\Utility;


class Debugger
{
    const LOG_FILE = '~/FlowBase.log';

    public static function log($message, $args = [], $inline = true)
    {

        if ($args !== [] && $inline === true) {
            $message = $message . ' - ' . json_encode($args);
        } elseif ($args !== [] && $inline === false) {
            $message = $message . PHP_EOL . print_r($args, true) . PHP_EOL;
        }

        $file = $_SERVER['HOME'] . '/FlowBase.log';
        file_put_contents(
            $file,
            time() . ': ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }
}