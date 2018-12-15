<?php

namespace App\Services;

use Exception;

/**
 * Class ServiceLoggerTrait
 *
 * Create Logs for Services
 *
 * @package App\Services
 */
trait ServiceLoggerTrait
{
    /**
     * Write Info Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logInfo($message, $log_name = null)
    {
        try {
            \Logger::writeService($this->getServiceName(), $message, 'info', $log_name, $this->isSupportService());
        } catch (Exception $e) {
            $this->loggingError($e);
        }

        return true;
    }

    /**
     * Write Warning Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logWarning($message, $log_name = null)
    {
        try {
            \Logger::writeService($this->getServiceName(), $message, 'warning', $log_name, $this->isSupportService());
        } catch (Exception $e) {
            $this->loggingError($e);
        }

        return true;
    }

    /**
     * Write Error Log
     *
     * @param $message
     * @param null $log_name
     * @return bool
     */
    protected function logError($message, $log_name = null)
    {
        try {
            \Logger::writeService($this->getServiceName(), $message, 'error', $log_name, $this->isSupportService());
        } catch (Exception $e) {
            $this->loggingError($e);
        }

        return true;
    }

    /**
     * Log Logging Error
     *
     * @param $error
     */
    private function loggingError($error)
    {
        \Logger::write('Logger Error:' . $error->getMessage(), 'info', storage_path() . '/logs/logger-errors.log');
    }

}