<?php

/*
 * Logger Service Settings
 *
 */

return [
    'enabled' => [
        'all_logs' => env('LOGGER_ENABLED_ALL_LOGS', true),
        'global_error_log' => true,
        'support_directory' => false,
        'separate_process_type' => false,
        'add_process_name' => false,
        'add_user_name' => false
    ]
];

