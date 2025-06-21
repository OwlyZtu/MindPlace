<?php

namespace app\services;

class DebugService
{
    public static function debug_to_console($message, $data)
    {
        $output = $data;
        if (is_array($output)) {
            foreach ($data as $key => $value) {
                $output = $key . ' => ' . $value;
            }
        }
        echo "<script>console.log('Debug Objects: " . $message . " ->->-> " . $output . "' );</script>";
    }
}
