<?php

namespace App\Services\Logger;

/**
 * Interface LoggerInterface
 *
 * @package App\Services\Logger
 */
interface LoggerInterface
{
    /**
     * Log Message
     *
     * @param $message
     * @param string $level
     * @param string $log_path
     * @param string $log_title
     * @return bool
     * @internal param string $log_name
     */
    public function write($message, $level = 'info', $log_path = null, $log_title = '');

    /**
     * Log Service Message
     *
     * @param $message
     * @param string $level
     * @param string $log_name
     * @param bool|false $is_support
     * @param $service_name
     * @return bool
     */
    public function writeService($service_name, $message, $level = 'info', $log_name = 'service', $is_support = false);

    /**
     * Log Command Message
     *
     * @param $message
     * @param string $level
     * @param string $log_name
     * @param $command_name
     * @return bool
     */
    public function writeCommand($command_name, $message, $level = 'info', $log_name = 'command');

}