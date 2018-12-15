<?php

namespace App\Http\Resources;

use Carbon\Carbon;

/**
 * Trait ResourceFormatter
 *
 * @package App\Http\Resources
 */
trait ResourceFormatter
{
    /**
     * Return Formatted Date
     *
     * @param $date
     * @return string
     */
    protected function formatDate($date)
    {
        return Carbon::parse($date)->format('Y-d-m');
    }

    /**
     * Return Formatted Date Time
     *
     * @param $date
     * @return string
     */
    protected function formatDateTime($date)
    {
        return Carbon::parse($date)->toIso8601String();
    }
}