<?php

namespace App\Services\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class MyLogger
 *
 * @package App\Services\Logger
 *
 * Log Class to write general individual log files
 *
 * 3 levels (info, warning, error)
 *
 */
class MyLogger implements LoggerInterface
{
    /**
     * Base log storage path
     *
     * @var string
     */
    private $base_path;

    /**
     * Logs Enabled Flag
     *
     * @var bool
     */
    private $all_logs_enabled;

    /**
     * Global Error Log Enabled Flag
     *
     * @var bool
     */
    private $global_error_log_enabled;

    /**
     * Separate Directory for Support Services Enabled
     *
     * @var bool
     */
    private $support_directory_enabled;

    /**
     * Add Process Name to Log
     *
     * @var bool
     */
    private $separate_process_type_enabled;

    /**
     * Add Process Name to Log
     *
     * @var bool
     */
    private $add_process_name_enabled;

    /**
     * Add User Name to Log
     *
     * @var bool
     */
    private $add_user_name_enabled;

    /**
     * Process name to add to log
     *
     * @var string
     */
    private $process_name;

    /**
     * Process user name to add to log
     *
     * @var string
     */
    private $user_name;

    /**
     * Logger Abstract Constructor
     *
     */
    public function __construct()
    {
        $this->base_path = storage_path() . '/logs/';
        $this->all_logs_enabled = (bool)config('support.logger.enabled.all_logs');
        $this->global_error_log_enabled = (bool)config('support.logger.enabled.global_error_log');
        $this->support_directory_enabled = (bool)config('support.logger.enabled.support_directory');
        $this->separate_process_type_enabled = (bool)config('support.logger.enabled.separate_process_type');
        $this->add_process_name_enabled = (bool)config('support.logger.enabled.add_process_name');
        $this->add_user_name_enabled = (bool)config('support.logger.enabled.add_user_name');
        $this->process_name = php_sapi_name();
        $this->user_name = posix_getpwuid(posix_geteuid())['name'];
    }


    /**
     * Log Message
     *
     * @param $message
     * @param string $level
     * @param string $log_path
     * @param string $log_title
     * @return bool
     * @throws \Exception
     */
    public function write($message, $level = 'info', $log_path = null, $log_title = '')
    {
        if ($this->all_logs_enabled) {

            $message = $this->formatMessage($message);
            $log_event_time = app()->make('log_event_time');

            $base_path = $this->base_path;

            if ($this->separate_process_type_enabled) {
                $base_path .= $this->process_name . '/';
                $this->makeDir($base_path);
            }

            if (is_null($log_path)) {
                $log_path = $this->buildLogName($base_path, 'general', '', $level);
            }

            // Write main log
            $service_log = new Logger($log_event_time);
            $service_log->pushHandler(new StreamHandler($log_path, Logger::INFO));
            $service_log->log($level, $message);

            // If error level log also write to master error log
            if ($level == 'error' && $this->global_error_log_enabled) {
                $log_path = $this->buildLogName($base_path, 'all-errors');
                $error_log = new Logger($log_event_time . ($log_title != '' ? '-' . $log_title : ''));
                $error_log->pushHandler(new StreamHandler($log_path, Logger::ERROR));
                $error_log->log($level, $message);
            }
        }

        return true;
    }

    /**
     * Log Service Message
     *
     * @param $service_name
     * @param $message
     * @param string $level
     * @param string $log_name
     * @param bool $is_support
     * @return bool
     * @throws \Exception
     */
    public function writeService($service_name, $message, $level = 'info', $log_name = 'service', $is_support = false)
    {
        if ($this->all_logs_enabled) {

            $base_path = $this->base_path;

            $service_name = $this->formatName($service_name);

            // Add Process Name
            if ($this->separate_process_type_enabled) {
                $base_path .= $this->process_name . '/';
                $this->makeDir($base_path);
            }

            // Add support folder
            if ($is_support && $this->support_directory_enabled) {
                $base_path .= 'support/';
                $this->makeDir($base_path);
            }

            // Add service name
            $base_path .= $service_name . '/';
            $this->makeDir($base_path);

            $log_path = $this->buildLogName($base_path, $log_name, $service_name, $level);

            $this->write($message, $level, $log_path, $service_name);
        }

        return true;
    }

    /**
     * Log Command Message
     *
     * @param $command_name
     * @param $message
     * @param string $level
     * @param string $log_name
     * @return bool
     * @throws \Exception
     */
    public function writeCommand($command_name, $message, $level = 'info', $log_name = 'command')
    {
        if ($this->all_logs_enabled) {

            $command_name = $this->formatName($command_name);

            $base_path = $this->base_path;

            // Add Process Name
            if ($this->separate_process_type_enabled) {
                $base_path .= $this->process_name . '/';
                $this->makeDir($base_path);
            }

            // Add commands to path
            $base_path .= 'commands/';
            $this->makeDir($base_path);

            // Add command name
            $base_path .= $this->formatName($command_name) . '/';
            $this->makeDir($base_path);

            $log_path = $this->buildLogName($base_path, $log_name, $command_name, $level);

            $this->write($message, $level, $log_path, $command_name);
        }

        return true;
    }

    /**
     * Make Dir
     *
     * @param $path
     */
    private function makeDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path);
        }
    }


    /**
     * Build Log Name
     *
     *
     * @param $base_path
     * @param $log_name
     * @param null $name
     * @param $level
     * @return string
     */
    private function buildLogName($base_path, $log_name, $name = null, $level = null)
    {
        // If custom log_name
        if (!is_null($log_name)) {
            $log_path = $base_path . $log_name;
        } else {
            $log_path = $base_path . $name;
        }

        if (is_null($log_name)) {
            switch ($level) {
                case 'info':
                    $log_path .= '-info';
                    break;
                case 'warning':
                    $log_path .= '-warning';
                    break;
                case 'error':
                    $log_path .= '-error';
                    break;
                case null:
                    break;
            }
        }

        if ($this->add_process_name_enabled) {
            $log_path .= '-' . $this->process_name;
        }

        if ($this->add_user_name_enabled) {
            $log_path .= '-' . $this->user_name;
        }

        $log_path .= '.log';

        return $log_path;
    }

    /**
     * Format Log Main Name
     *
     * @param $name
     * @return string
     */
    private function formatName($name)
    {
        return strtolower(str_replace(' ', '_', $name));
    }

    /**
     * Format Log Message
     *
     * @param $message
     * @return mixed
     */
    private function formatMessage($message)
    {
        // Turn array message into string
        if (is_array($message)) {
            $message = print_r($message, true);
        }

        // Turn object into string
        if (is_object($message)) {
            $message = print_r(get_object_vars($message), true);
        }

        return $message;
    }
}