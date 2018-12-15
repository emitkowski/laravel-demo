<?php

/**
 * Echo Dump
 *
 * @param $input
 * @param int $die
 */
function er($input, $die = 0)
{
    echo($input . '<br />');

    if ($die) {
        die();
    }
}

/**
 * Print Dump
 *
 * @param $input
 * @param int $die
 */
function pr($input, $die = 0)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';

    if ($die) {
        die();
    }
}

/**
 * Get IP Address
 *
 * @return mixed
 */
function getIpAddress()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
