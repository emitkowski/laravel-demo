<?php

namespace App\Listeners;

/**
 * Class AuthLoginInfoUpdate
 *
 * @package App\Listeners
 */
class AuthLoginInfoUpdate
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Updates login date and IP address for users
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        auth()->user()->last_login = now();
        auth()->user()->last_login_ip = getIpAddress();
        auth()->user()->save();
    }
}
