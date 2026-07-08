<?php

if (!function_exists('profiler_step_start')) {
    function profiler_step_start($name) {
        $GLOBALS['deep_profile_starts'][$name] = microtime(true);
    }
    function profiler_step_end($name) {
        if (isset($GLOBALS['deep_profile_starts'][$name])) {
            $time = (microtime(true) - $GLOBALS['deep_profile_starts'][$name]) * 1000;
            $GLOBALS['deep_profile_data'][] = ['type' => 'Step', 'name' => $name, 'time' => $time];
        }
    }
}
